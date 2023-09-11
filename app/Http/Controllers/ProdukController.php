<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{

    public function getProductsByPaket($id)
    {
        $produk = Produk::where('id_paket', $id)->get();
        return response()->json($produk);
    }


    public function produk() {
        $data = Produk::get();
        $namapaket = Paket::get();
        return view('admin.produk.produk', compact('data', 'namapaket'));
    }

    public function create() {

        $data = Produk::get();
        $namapaket = Paket::get();
        return view('admin.produk.create', compact('data', 'namapaket'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'id_paket'      => 'required',
            'nama_produk'   => 'required',
            'harga'         => 'required',
            'info'          => 'required',
        ]);

        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['id_paket']       = $request->id_paket;
        $data['nama_produk']    = $request->nama_produk;
        $data['harga']          = $request->harga;
        $data['info']           = $request->info;

        Produk::create($data);

        return redirect()->route('admin.produk');

    }

    public function edit(Request $request,$id) {
        $data = Produk::find($id);
        $namapaket = Paket::get();
        return view('admin.produk.edit', compact('data', 'namapaket'));
    }

    public function update(Request $request,$id) {
        $validator = Validator::make($request->all(),[
            'id_paket'      => 'required',
            'nama_produk'   => 'required',
            'harga'         => 'required',
            'info'          => 'required',
        ]);

        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['id_paket']       = $request->id_paket;
        $data['nama_produk']    = $request->nama_produk;
        $data['harga']          = $request->harga;
        $data['info']           = $request->info;

        Produk::whereId($id)->update($data);

        return redirect()->route('admin.produk');
    }

    public function delete($id) {
        $data = Produk::find($id);

        if($data) {
            $data -> delete();
        }

        return redirect()->route('admin.produk');
    }
}
