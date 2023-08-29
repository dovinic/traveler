<?php

namespace Database\Seeders;


use App\Models\Kota;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kota::create([
            'kota'  => 'Malang',
            'harga'  => 0,
        ]);
    }
}
