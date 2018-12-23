<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    public function item(){
        return $this->hasOne(Item::class);
    }
    
}
