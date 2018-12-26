<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
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
}
