<?php

namespace App\Http\Controllers;

use App\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Discount::all();
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
            'price' => 'required',
            'expire' => 'required',
        ]);
        
        $item = new Discount;
        $item->cupon = bin2hex(random_bytes(5));
        $item->price = $request->price;
        $item->expire = $request->expire;
        $item->save();
        return 'Berhasil';

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show($cupon)
    {
        $discount = Discount::where('cupon',$cupon)->first();
        if($discount->expire == 0){
            return 0;
        }else{
            return $discount->price;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
        $this->validate($request, [
            'price' => 'required',
            'expire' => 'required',
        ]);

        $item = Discount::findOrFail($id);
        $item->price = $request->price;
        $item->expire = $request->expire;
        $item->save();
        return 'Berhasil';

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Discount::findOrFail($id);
        $item->delete();
        return 'Berhasil';

    }
}
