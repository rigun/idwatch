<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RajaOngkir;
class RajaOngkirController extends Controller
{
    public function index(){
        return RajaOngkir::Provinsi()->all();
    }
}
