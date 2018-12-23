<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function picture(){
        return $this->hasMany(Picture::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
