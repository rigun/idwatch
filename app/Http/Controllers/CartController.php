<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Cart::all());
    }

    public function showByUser()
    {
        return Cart::where([['user_id', JWTAuth::parseToken()->authenticate()->id],['status',0]] )->with('user','item')->get();
    }
    public function countCart()
    {
        return Cart::where([['user_id', JWTAuth::parseToken()->authenticate()->id],['status',0]])->count();
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
            'quantity' => 'required',
            'item_id' => 'required',
        ]);
        
        if(!$cart = Cart::where([['user_id',JWTAuth::parseToken()->authenticate()->id],['item_id', $request->item_id],['status', 0]])->first()){
            $cart = new Cart();
            $cart->user_id = JWTAuth::parseToken()->authenticate()->id;
            $cart->item_id = $request->item_id;
        }
        $cart->quantity = $request->quantity;
        $cart->save();

        return $cart;
    }
    public function updateQuantity(Request $request, $id)
    {
        $this->validate($request, [
            'quantity' => 'required',
        ]);
        
        $cart = Cart::findOrFail($id);
        $cart->quantity = $request->quantity;
        $cart->save();

        return $cart;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'quantity' => 'required',
            'item_id' => 'required',
        ]);

        $cart = Cart::findOrFail($id);
        $cart->quantity = $request->quantity;
        $cart->save();

        return $cart;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy($id )
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return 'Terhapus';
    }
}
