<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    public function cart(){
        return $this->belongsTo(Cart::class)->with('item');
    }

}
