<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Kota;
use App\Models\Paket;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KotaController extends Controller
{

    public function getProductsByPaket($id)
    {
        $produk = Produk::where('id_paket', $id)->get();
        return response()->json($produk);
    }


    public function kota() {
        $data = Kota::get();
        $namapaket = Paket::get();
        $proses = Log::count();
        return view('admin.kota.kota', compact('data', 'namapaket', 'proses'));
    }

    public function create() {

        $data = Produk::get();
        $namapaket = Paket::get();
        return view('admin.kota.create', compact('data', 'namapaket'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'kota'  => 'required',
            'harga' => 'required',
        ]);

        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['kota']   = $request->kota;
        $data['harga']  = $request->harga;

        Kota::create($data);

        return redirect()->route('admin.kota');

    }

    public function edit(Request $request,$id) {
        $data = Kota::find($id);
        $namapaket = Paket::get();
        return view('admin.kota.edit', compact('data', 'namapaket'));
    }

    public function update(Request $request,$id) {
        $validator = Validator::make($request->all(),[
            'kota'  => 'required',
            'harga' => 'required',
        ]);

        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['kota']   = $request->kota;
        $data['harga']  = $request->harga;

        Kota::whereId($id)->update($data);

        return redirect()->route('admin.kota');
    }

    public function delete($id) {
        $data = Kota::find($id);

        if($data) {
            $data -> delete();
        }

        return redirect()->route('admin.kota');
    }
}
