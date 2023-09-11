<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kota;
use App\Models\Paket;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{

    public function transaksi() {
        $data = Transaksi::get();
        $namapaket = Paket::get();
        $namaproduk = Produk::get();
        return view('admin.transaksi.transaksi', compact('data', 'namapaket', 'namaproduk'));
    }

    public function edit(Request $request,$id) {
        $data = Transaksi::find($id);
        $namapaket = Paket::get();
        $namaproduk = Produk::get();
        $produk = Produk::where('id_paket', '1')->first();

        return view('admin.transaksi.edit', compact('data', 'namapaket', 'namaproduk'));
    }

    public function update(Request $request,$id) {
        $validator = Validator::make($request->all(),[
            'total_harga'         => 'required',
            'status'              => 'required',
            'id_paket'            => 'required',
            'id_produk'           => 'required',
        ]);

        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['id_paket']       = $request->id_paket;
        $data['id_produk']      = $request->id_produk;
        $data['total_harga']    = $request->total_harga;
        $data['status']         = $request->status;

        Transaksi::whereId($id)->update($data);

        return redirect()->route('admin.transaksi');
    }

    public function delete($id) {
        $data = Transaksi::find($id);

        if($data) {
            $data -> delete();
        }

        return redirect()->route('admin.transaksi');
    }

    public function viewFile($filename)
    {
        $filePath = 'public/uploads/' . $filename;

        if (Storage::exists($filePath)) {
            return response()->file(storage_path('app/' . $filePath));
        } else {
            abort(404);
        }
    }

    public function invoice(Request $request,$id) {
        $allpaket = Paket::get();
        $allproduk = Produk::get();
        $transaksi = Transaksi::where('id_transaksi', $id)->get();
        $kota = Kota::get();
        $tgl_berangkat = $transaksi->map(function ($transaksi) {
            return Carbon::parse($transaksi->tgl_berangkat)->format('d F Y');
        });
        $tgl_invoice = $transaksi->map(function ($transaksi) {
            return Carbon::parse($transaksi->created_at)->format('d F Y');
        });
        if ($transaksi->isNotEmpty()) {
            $buyer = $transaksi[0];
            return view('client.invoice',compact('transaksi','allpaket','allproduk','buyer','tgl_berangkat','tgl_invoice','kota'));
        } else {
            return view('client.riwayat',compact('transaksi','allpaket'));
        }
    }
}
