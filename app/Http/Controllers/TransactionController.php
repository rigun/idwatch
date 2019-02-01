<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Cart;
use App\User;
use App\UsersDetail;
use App\TransactionDetail;
use App\Item;
use Illuminate\Http\Request;
use App\Exports\ReportItem;
// use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use DateTime;
use PDF;
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
    public function myhistory()
    {
        return Transaction::where('user_id',JWTAuth::parseToken()->authenticate()->id)->with(['detail','user'])->get();
    }
    public function export() 
    {
        // return Excel::download(new ReportItem(1), 'report.pdf');
        $data = Transaction::where('status','>=',3)->with(['detail','user'])->get();
        $countTotal = Transaction::where('status','>=',3)->with(['detail','user'])->sum('total');
        
        view()->share(['data' => $data,'countTotal' => $countTotal]);
        $pdf = PDF::loadView('pdf.report');
        return $pdf->download('report.pdf');
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
    public function graph(){
        $transactions = Transaction::where([['status','>=',3]])->get();
        $T_today = 0;
        $T_month = 0;
        $T_year = 0;
        $P_today = 0;
        $P_month = 0;
        $P_year = 0;
        $pending = Transaction::where([['status','<',3],['notes','!=',null]])->count();
        $barang = Item::all()->count();
        $now = new DateTime();
        foreach($transactions as $transaction){
            if($transaction->created_at->format('Y') == $now->format('Y')){
                $T_year++;
                $P_year = $P_year + $transaction->total;
                if($transaction->created_at->format('m') == $now->format('m')){
                    $T_month++;
                    $P_month = $P_month + $transaction->total;                    
                    if($transaction->created_at->format('d') == $now->format('d')){
                        $T_today++;
                    $P_today = $P_today + $transaction->total;                        
                    }
                }
            }
        } 
       return response()->json(['T_today'=> $T_today, 'T_month'=> $T_month, 'T_year'=> $T_year,'P_today'=> $P_today, 'P_month'=> $P_month, 'P_year'=> $P_year,'Pending' => $pending,'Barang'=>$barang]);
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
        if(Transaction::where([['user_id',JWTAuth::parseToken()->authenticate()->id],['status', '<',3],['notes','!=',null]])->first()){
            return 0;
        }
        if(!$transaction = Transaction::where([['user_id',JWTAuth::parseToken()->authenticate()->id],['status', 0]])->first()){
            $transaction = new Transaction();
            $transaction->user_id = JWTAuth::parseToken()->authenticate()->id;
            $transaction->token = bin2hex(random_bytes(60));
        }
        $transaction->provinsi = $request->provinsi;
        $transaction->kota = $request->kota;
        $transaction->type_shipping = $request->type_shipping;
        $transaction->service_shipping = $request->service_shipping;
        $transaction->estimate_shipping = $request->estimate_shipping;
        $transaction->shipping = $request->shipping;
        $transaction->total = $request->total;
        $transaction->diskon = $request->diskon;
        $transaction->save();

        if(!$uDetail = UsersDetail::where('user_id', JWTAuth::parseToken()->authenticate()->id )->first()){
            $uDetail = new UsersDetail();
            $uDetail->user_id = JWTAuth::parseToken()->authenticate()->id;
        }
        $uDetail->provinsi = $request->provinsi;
        $uDetail->kota = $request->kota;
        $uDetail->save();

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
        return response()->json(["cart" => $cart , "id" => $transaction->id, "file" => $transaction->evidence, "total" => $transaction->total]);
    }
    public function count(){
        return Transaction::where([['status','<',3],['notes','!=',null]])->count();
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
    public function destroyHistory($id)
    {
        $item = Transaction::where([['user_id',JWTAuth::parseToken()->authenticate()->id],['id',$id]])->first();
        if($detail = TransactionDetail::where([['transaction_id', $item->id]])->get()){
            foreach($detail as $dt)
            {
                $dt->delete();
            }
        }
       
        $item->delete();
        return 'success';

    }
    public function destroy($id)
    {
        $transaction = Transaction::where([['id',$id]])->first();
        if($detail = TransactionDetail::where([['transaction_id', $transaction->id]])->get()){
            foreach($detail as $dt)
            {
                $cart = Cart::where('id',$dt->cart_id)->first();
                $item = Item::where('id',$cart->item_id)->first();
                $item->stock += $cart->quantity;
                $item->save();
                $dt->delete();
            }
        }
       
        $transaction->delete();
        return 'success';

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
