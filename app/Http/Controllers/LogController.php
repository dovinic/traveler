<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function log() {
        $logs = Log::get();
        $transaksi = Transaksi::get();

        foreach ($logs as $l) {
            // Loop melalui array transaksi
            foreach ($transaksi as $t) {
                // Memeriksa apakah $l->invoice sama dengan $t->id_transaksi
                if ($l->invoice == $t->id_transaksi) {
                    if ($t->status != 'Proses') {
                        // Menghapus log berdasarkan invoice yang sesuai
                        Log::where('invoice', $t->id_transaksi)->delete();
                    }
                }
            }
        }

        foreach ($logs as $log) {
            $log->diff = $this->hitungSelisihWaktu($log->created_at);
        }

        return view('log/log', compact('logs', 'transaksi'));
    }

    private function hitungSelisihWaktu($createdAt) {
        // Menghitung selisih waktu antara waktu yang dibuat dengan waktu sekarang
        $createdAt = Carbon::parse($createdAt);
        $now = Carbon::now();
        return $createdAt->diffForHumans($now);
    }
}
