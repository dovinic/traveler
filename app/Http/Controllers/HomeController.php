<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\User;
use App\Traits\FormatRupiah;

class HomeController extends Controller
{

    public function dashboard() {
        $namauser = User::get();
        $produk = Produk::get();
        $totalproduk = Produk::count();
        $totalpaket = Paket::count();
        $totaltransaksi = Transaksi::count();
        $pemasukan = Transaksi::where('status', 'Lunas')->sum('total_harga');
        $paket = Paket::get();
        return view('admin.dashboard', compact('produk', 'totalproduk', 'paket', 'totalpaket', 'namauser', 'totaltransaksi','pemasukan'));
    }

}
