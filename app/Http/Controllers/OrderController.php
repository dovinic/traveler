<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kota;
use App\Models\Log;
use App\Models\Paket;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PgSql\Lob;

class OrderController extends Controller
{
    public function order(Request $request,$id) {
        $paket = Paket::find($id);
        $allpaket = Paket::get();
        $kota = Kota::get();
        $produk = Produk::where('id_paket', $id)->get();
        return view('order',compact('paket', 'produk', 'allpaket','kota'));
    }

    public function directorder() {
        return redirect()->route('dashboard2');
    }

    public function index() {
        $totaltransaksi = Transaksi::where('status', 'Lunas')->count();
        $allpaket = Paket::get();
        return view('dashboard2', compact('allpaket','totaltransaksi'));
    }

    public function send(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'id_paket' => 'required',
            'id_produk' => 'required',
            'tgl_berangkat' => 'required|date_format:m/d/Y',
            'phone_number' => ['required', 'regex:/^8\d+$/'],
            'kota'          => 'required',
            'g-recaptcha-response' => ['required', 'captcha'],
        ],
        [
            'nama.required' => 'Nama wajib diisi',
            'id_produk.required' => 'Jumlah Orang wajib diisi',
            'tgl_berangkat.required' => 'Tanggal Berangkat wajib diisi',
            'phone_number.required' => 'Nomor HP wajib diisi',
            'phone_number.regex' => 'Nomor telepon harus dimulai dengan angka 8.',
            'kota.required' => 'Lokasi Penjemputan Wajib diisi',
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // Mengambil harga dari database berdasarkan id_produk
        $tgl_berangkat = \Carbon\Carbon::createFromFormat('m/d/Y', $request->tgl_berangkat)->format('Y/m/d');
        $id_produk = $request->id_produk;
        $kota = $request->kota;
        $harga_paket = Produk::where('id', $id_produk)->value('harga');
        $harga_jemput = Kota::where('kota', $kota)->value('harga');
        $harga = $harga_paket + $harga_jemput;
        $id_transaksi = Transaksi::generateRandomId();

        // Membuat data transaksi dengan harga dari database
        $data = [
            'nama' => $request->nama,
            'id_paket' => $request->id_paket,
            'id_produk' => $id_produk,
            'total_harga' => $harga,
            'id_transaksi'  => $id_transaksi,
            'tgl_berangkat' => $tgl_berangkat,
            'status'        => 'Belum Bayar',
            'phone_number'  => $request->phone_number,
            'penjemputan'   => $kota,
        ];


        Transaksi::create($data);

        return redirect()->route('history',['id' => $id_transaksi]);
    }

    public function getPrice($id)
    {
        $price = Produk::where('id', $id)->get();
        return response()->json($price);
    }

    public function history(Request $request,$id) {
        $allpaket = Paket::get();
        $allproduk = Produk::get();
        $kota = Kota::get();
        $transaksi = Transaksi::where('id_transaksi', $id)->get();
        $tanggalBerangkat = $transaksi->map(function ($transaksi) {
            return Carbon::parse($transaksi->tgl_berangkat)->format('d F Y');
        });
        $tgl_berangkat = $tanggalBerangkat;

        if ($transaksi->isNotEmpty()) {
            $invoice = $transaksi[0]->id_transaksi;
            return view('history',compact('transaksi','allpaket','allproduk','invoice','tgl_berangkat','kota'));
        } else {
            return view('riwayat',compact('transaksi','allpaket'));
        }
    }

    public function riwayat() {
        $transaksi = Transaksi::get();
        $allpaket = Paket::get();
        return view('riwayat',compact('allpaket','transaksi'));
    }

    public function cari(Request $request) {
        $validator = Validator::make($request->all(), [
            'id_transaksi' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $id_transaksi = $request->id_transaksi;

        return redirect()->route('history',['id' => $id_transaksi]);
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
        $buyer = $transaksi[0];
        if ($transaksi->isNotEmpty()) {
            return view('invoice',compact('transaksi','allpaket','allproduk','buyer','tgl_berangkat','tgl_invoice','kota'));
        } else {
            return view('riwayat',compact('transaksi','allpaket'));
        }
    }

    public function proof(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ],
        [
            'file.required' => 'Wajib Isi File!',
            'file.mimes'    => 'File Wajib jpg/jpeg/png/pdf',
            'file.max'      => 'File Maksimum 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $uploadedFile = $request->file('file');

        // Buat nama file baru berdasarkan $id
        $newFileName = $id . '_' . Str::random(10) . '.' . $uploadedFile->getClientOriginalExtension();

        // Simpan file dengan nama baru di direktori 'public/uploads'
        $uploadedFile->storeAs('public/uploads', $newFileName);

        // Ambil objek transaksi dengan ID tertentu
        $transaksi = Transaksi::where('id_transaksi', $id)->firstOrFail();

        // Tambahkan informasi file ke dalam database
        $transaksi->file = $newFileName;
        $transaksi->status = 'Proses';
        // Tambahkan kolom lain yang sesuai jika diperlukan
        $transaksi->save();

        $data = [
            'nama'      => $transaksi->nama,
            'invoice'   => $transaksi->id_transaksi,
            'id2'       => $transaksi->id,
        ];


        Log::create($data);

        return redirect()->route('history',['id' => $id])->with('success', 'Pesanan berhasil diperbarui.');
    }


}
