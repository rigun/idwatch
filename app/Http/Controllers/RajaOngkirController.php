<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RajaOngkir;
class RajaOngkirController extends Controller
{
    public function index(){
    }

    public function provinsi(){
        return RajaOngkir::Provinsi()->all();
    }
    public function kotaByProvinsi($provinsi_id){
        return RajaOngkir::Kota()->byProvinsi($provinsi_id)->get();
    }
    public function cost($id_kota, $weight){
        $jne = RajaOngkir::Cost([
            'origin' 		=> 501, // id kota asal
            'destination' 	=> $id_kota, // id kota tujuan
            'weight' 		=> $weight, // berat satuan gram
            'courier' 		=> 'jne', // kode kurir pengantar ( jne / tiki / pos )
        ])->get();
        $tiki = RajaOngkir::Cost([
            'origin' 		=> 501, // id kota asal
            'destination' 	=> $id_kota, // id kota tujuan
            'weight' 		=> $weight, // berat satuan gram
            'courier' 		=> 'jne', // kode kurir pengantar ( jne / tiki / pos )
        ])->get();
        $pos = RajaOngkir::Cost([
            'origin' 		=> 501, // id kota asal
            'destination' 	=> $id_kota, // id kota tujuan
            'weight' 		=> $weight, // berat satuan gram
            'courier' 		=> 'jne', // kode kurir pengantar ( jne / tiki / pos )
        ])->get();

        return response()->json(['jne' => $jne, 'tiki' => $tiki, 'pos' => 'pos']);

    }
}
