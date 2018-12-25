<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Cart;
use App\UsersDetail;
use App\TransactionDetail;
use App\Item;
use Illuminate\Http\Request;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class TransactionController extends Controller
{
    private $photos_path;
 
    public function __construct()
    {
        $this->photos_path = public_path('/itemImages');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Transaction::with(['detail','user'])->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'shipping' => 'required',
            'total' => 'required',
        ]);
        
        if(!$transaction = Transaction::where([['user_id',JWTAuth::parseToken()->authenticate()->id],['status', 0]])->first()){
            $transaction = new Transaction();
            $transaction->user_id = JWTAuth::parseToken()->authenticate()->id;
            $transaction->token = bin2hex(random_bytes(60));
        }
        
        $transaction->shipping = $request->shipping;
        $transaction->total = $request->total;
        if($request->diskon != null){
            $transaction->diskon = $request->diskon;
        }
        $transaction->save();

        $carts = Cart::where([['user_id', JWTAuth::parseToken()->authenticate()->id ],['status',0]])->get();
        foreach($carts as $cart)
        {
            if(!$detail = TransactionDetail::where([['transaction_id', $transaction->id],['cart_id',  $cart->id]])->first()){
                $detail = new TransactionDetail();
                $detail->transaction_id = $transaction->id;
                $detail->cart_id = $cart->id;
                $detail->save();
            }
            
        }

        return $transaction->token;
    }
    public function order(Request $request){
        $this->validate($request, [
            'phone' => 'required',
            'address' => 'required',
            'status' => 'required',
            'transaction_id' => 'required',
            'notes' => 'required',
        ]);
        
        $transaction = Transaction::findOrFail($request->transaction_id);
        if($transaction->status == 0){
            $transaction->status = $request->status;
            $transaction->address = $request->address;
            $transaction->notes = $request->notes;
            $transaction->save();

            if(!$detail = UsersDetail::where('user_id', JWTAuth::parseToken()->authenticate()->id )->first()){
                $detail = new UsersDetail();
                $detail->user_id = JWTAuth::parseToken()->authenticate()->id;
            }
            $detail->phone = $request->phone;
            $detail->alamat = $request->address;
            $detail->save();

            $carts = Cart::where([['user_id', JWTAuth::parseToken()->authenticate()->id],['status',0]] )->get();
            foreach($carts as $cart)
            {
                $item = Item::findOrFail($cart->item_id);
                $item->stock = $item->stock - $cart->quantity;
                $item->save();

                $cart->status = 1;
                $cart->save();                
            }

        }
        return "Success";
    }
    public function checkoutcartByUser(){
        $transaction = Transaction::where([['user_id',JWTAuth::parseToken()->authenticate()->id],['status','<',3],['notes','!=',null]])->with('detail')->first();
        foreach($transaction->detail as $dt){
            $cart[] = $dt->cart;
        }
        return response()->json(["cart" => $cart , "id" => $transaction->id, "file" => $transaction->evidence]);
    }
    public function count(){
        return Transaction::where('status','<',3)->count();
    }
    public function evidence(Request $request, $id){
        $transaction = Transaction::findOrFail($id);
        if($request->hasfile('filename'))
         {

            foreach($request->file('filename') as $image)
            {
                $name = sha1(date('YmdHis') . str_random(30));
                $save_name = $name . '.' . $image->getClientOriginalExtension();

                $original_name =$image->getClientOriginalName();
                $image->move($this->photos_path, $save_name);  

                $transaction->evidence=$save_name;
                $transaction->save();
            }
         }
        return 'Terupload';
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show($token)
    {
        $transaction = Transaction::where('token',$token)->with(['detail','user'])->first();
        return $transaction;
    }
    public function verifikasi(Request $request, $id){
        $this->validate($request, [
            'status' => 'required',
        ]);
        
        $transaction = Transaction::findOrFail($id);
        $transaction->status = $request->status;
        $transaction->save();
        return $transaction;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
    public function deleteEvidence($id){
        $image = Transaction::findOrFail($id);

    
        $file_path = $this->photos_path . '/' . $image->evidence;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        
        if (!empty($image)) {
            $image->evidence = null;
            $image->save();
        }
        return "terhapus";
    }
}
