<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaftarPulsaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hargaPulsa = [
            ['harga_pulsa' => 5000, 'harga_jual' => 7000],
            ['harga_pulsa' => 10000, 'harga_jual' => 12000],
            ['harga_pulsa' => 20000, 'harga_jual' => 22000],
            ['harga_pulsa' => 25000, 'harga_jual' => 27000],
            ['harga_pulsa' => 50000, 'harga_jual' => 52000],
            ['harga_pulsa' => 100000, 'harga_jual' => 102000],
        ];

        foreach ($hargaPulsa as $harga) {
            DB::table('daftar_pulsa')->insert([
                'harga_pulsa' => $harga['harga_pulsa'],
                'harga_jual' => $harga['harga_jual'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
