<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaksi::create([
            'nama'          => 'Ridho',
            'id_paket'      => '1',
            'id_produk'     => '1',
            'total_harga'   => '3500000',
            'id_transaksi'  => Transaksi::generateRandomId(),
        ]);
    }
}
