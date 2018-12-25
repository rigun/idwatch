<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function detail(){
        return $this->hasMany(TransactionDetail::class)->with('cart');
    }

    public function user(){
        return $this->belongsTo(User::class)->with('detail');
    }
}
