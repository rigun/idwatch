<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use App\Mail\ForgetPasswordMail;
use App\User;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function send(Request $request)
    {
        $this->validateWith([
            'email' => 'required',
            'name' => 'required',
            'subject' => 'required',
            'message' => 'required',
          ]);
        $objDemo = new \stdClass();
        $objDemo->email = $request->email;
        $objDemo->name = $request->name;
        $objDemo->subject = $request->subject;
        $objDemo->message = $request->message;
 
        Mail::to('idwatchshop88@gmail.com')->send(new ContactMail($objDemo));
        return 'email terkirim';
    }
    public function forgetpassword(){
        $this->validateWith([
            'email' => 'required',
          ]);

          $user= User::findOrFail($request->email);
          $user->status = rand(1000,100000);
          $user->save();

          Mail::to($user->email)->send(new ForgetPasswordMail($user));
          return 'email terkirim';
    }
    
}
