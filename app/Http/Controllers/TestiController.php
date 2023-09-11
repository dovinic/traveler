<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Produk;
use App\Models\Testimoni;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestiController extends Controller
{
    public function testimoni() {
        $data = Testimoni::get();
        $namapaket = Paket::get();
        $namaproduk = Produk::get();
        return view('admin.testimoni.testimoni', compact('data', 'namapaket', 'namaproduk'));
    }

    public function update(Request $request,$id) {
        $validator = Validator::make($request->all(),[
            'action'         => 'required',
        ]);

        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['action']      = $request->action;

        Testimoni::whereId($id)->update($data);

        return redirect()->route('admin.testimoni');
    }
}
