<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produk::create([
            'id_paket'   => '1',
            'nama_produk'   => '1-5 Orang',
            'harga'         => '1500000',
            'info'          => 'Tes',
        ]);
    }
}
