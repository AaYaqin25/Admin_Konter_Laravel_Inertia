<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaftarKuotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftarKuota = [
            // Tri
            ['deskripsi_kuota' => 'Tri Data 2.75 GB / 7 Hari', 'harga_kuota' => 18000, 'stok' => 3, 'harga_modal' => 16233, 'provider' => 'Tri'],
            ['deskripsi_kuota' => 'Tri Data 1.5 GB / 14 Hari', 'harga_kuota' => 10000, 'stok' => 5, 'harga_modal' => 8737, 'provider' => 'Tri'],
            ['deskripsi_kuota' => 'Tri Data 5 GB / 30 Hari', 'harga_kuota' => 32000, 'stok' => 3, 'harga_modal' => 30466, 'harga_promo' => 31000, 'provider' => 'Tri'],
            ['deskripsi_kuota' => 'Tri Data 10 GB / 30 Hari', 'harga_kuota' => 57000, 'stok' => 4, 'harga_modal' => 54778, 'provider' => 'Tri'],
            ['deskripsi_kuota' => 'AlwaysOn 12 GB', 'harga_kuota' => 60000, 'stok' => 16, 'harga_modal' => 57439, 'provider' => 'Tri'],
            ['deskripsi_kuota' => 'AlwaysOn 40 GB', 'harga_kuota' => 110000, 'stok' => 15, 'harga_modal' => 107535, 'harga_promo' => 109000, 'provider' => 'Tri'],
            // Telkomsel
            ['deskripsi_kuota' => 'Telkomsel Data Flash 1 GB 30 Hari', 'harga_kuota' => 12000, 'stok' => 3, 'harga_modal' => 11533, 'provider' => 'Telkomsel'],
            ['deskripsi_kuota' => 'Telkomsel Data Flash 2 GB 30 Hari', 'harga_kuota' => 23000, 'stok' => 5, 'harga_modal' => 22038, 'provider' => 'Telkomsel'],
            ['deskripsi_kuota' => 'Telkomsel Data Flash 3 GB 30 Hari', 'harga_kuota' => 25000, 'stok' => 3, 'harga_modal' => 23274, 'harga_promo' => 24000, 'provider' => 'Telkomsel'],
            ['deskripsi_kuota' => 'Telkomsel Data Flash 5 GB 30 Hari', 'harga_kuota' => 35000, 'stok' => 4, 'harga_modal' => 33758, 'provider' => 'Telkomsel'],
            ['deskripsi_kuota' => 'Telkomsel Data Flash 8 GB 30 Hari', 'harga_kuota' => 49000, 'stok' => 16, 'harga_modal' => 47484, 'provider' => 'Telkomsel'],
            ['deskripsi_kuota' => 'Telkomsel Data Flash 10 GB 30 Hari', 'harga_kuota' => 60000, 'stok' => 15, 'harga_modal' => 58182, 'harga_promo' => 59000, 'provider' => 'Telkomsel'],
            //XL
            ['deskripsi_kuota' => 'Paket Blue 3GB, 2hr', 'harga_kuota' => 11000, 'stok' => 7, 'harga_modal' => 10000, 'provider' => 'XL'],
            ['deskripsi_kuota' => 'XTRA ON 1GB', 'harga_kuota' => 17000, 'stok' => 6, 'harga_modal' => 15000, 'harga_promo' => 16000, 'provider' => 'XL'],
            ['deskripsi_kuota' => 'XTRA ON 2GB', 'harga_kuota' => 26000, 'stok' => 5, 'harga_modal' => 25000, 'provider' => 'XL'],
            ['deskripsi_kuota' => 'Xtra Combo Double Youtube 5GB+10GB', 'harga_kuota' => 62000, 'stok' => 11, 'harga_modal' => 59500, 'provider' => 'XL'],
            ['deskripsi_kuota' => 'Xtra Combo Flex XL 18GB Kuota Utama + Kuota Area hingga 25GB + Bonus Flex', 'harga_kuota' => 102000, 'stok' => 10, 'harga_modal' => 100000, 'harga_promo' => 101000, 'provider' => 'XL'],
            ['deskripsi_kuota' => 'Xtra Combo Double Youtube 35GB+70GB', 'harga_kuota' => 240000, 'stok' => 3, 'harga_modal' => 239000, 'provider' => 'XL'],
            // Indosat
            ['deskripsi_kuota' => 'Indosat Freedom Internet 1 GB 2 Hari', 'harga_kuota' => 7000, 'stok' => 7, 'harga_modal' => 5875, 'provider' => 'Indosat'],
            ['deskripsi_kuota' => 'Indosat Freedom Internet 3 GB 3 Hari', 'harga_kuota' => 12000, 'stok' => 6, 'harga_modal' => 9927, 'harga_promo' => 11000, 'provider' => 'Indosat'],
            ['deskripsi_kuota' => 'Indosat Freedom Internet 5 GB 3 Hari', 'harga_kuota' => 22000, 'stok' => 5, 'harga_modal' => 19602, 'provider' => 'Indosat'],
            ['deskripsi_kuota' => 'Indosat Freedom Internet 9 GB 30 Hari', 'harga_kuota' => 45000, 'stok' => 11, 'harga_modal' => 43002, 'provider' => 'Indosat'],
            ['deskripsi_kuota' => 'Indosat Freedom Internet 15 GB 30 Hari', 'harga_kuota' => 67000, 'stok' => 10, 'harga_modal' => 64640, 'harga_promo' => 66000, 'provider' => 'Indosat'],
            ['deskripsi_kuota' => 'Indosat Freedom Internet 20 GB 30 Hari', 'harga_kuota' => 72000, 'stok' => 3, 'harga_modal' => 69690, 'provider' => 'Indosat'],
            // Smartfren
            ['deskripsi_kuota' => 'Smartfren Data 1 GB 3 Hari', 'harga_kuota' => 5000, 'stok' => 7, 'harga_modal' => 4553, 'provider' => 'Smartfren'],
            ['deskripsi_kuota' => 'Smartfren Data 2 GB 3 Hari', 'harga_kuota' => 9000, 'stok' => 6, 'harga_modal' =>  7471, 'harga_promo' => 8000, 'provider' => 'Smartfren'],
            ['deskripsi_kuota' => 'Smartfren Data 3 GB 5 Hari', 'harga_kuota' => 12000, 'stok' => 5, 'harga_modal' => 11092, 'provider' => 'Smartfren'],
            ['deskripsi_kuota' => 'Smartfren Data Unlimited Harian 700 MB 28 Hari', 'harga_kuota' => 70000, 'stok' => 11, 'harga_modal' => 68170, 'provider' => 'Smartfren'],
            ['deskripsi_kuota' => 'Smartfren Data Unlimited Harian 2 GB 28 Hari', 'harga_kuota' => 88000, 'stok' => 10, 'harga_modal' => 85037, 'harga_promo' => 87000, 'provider' => 'Smartfren'],
            ['deskripsi_kuota' => 'Smartfren Data Unlimited Harian 3 GB 28 Hari', 'harga_kuota' => 107000, 'stok' => 3, 'harga_modal' => 104782, 'provider' => 'Smartfren'],
            // AXIS
            ['deskripsi_kuota' => 'Axis Data BRONET 1 GB 1 Hari', 'harga_kuota' => 6000, 'stok' => 7, 'harga_modal' => 4797, 'provider' => 'AXIS'],
            ['deskripsi_kuota' => 'Axis Data BRONET 2 GB 30 Hari', 'harga_kuota' => 15000, 'stok' => 6, 'harga_modal' =>  13534, 'harga_promo' => 14000, 'provider' => 'AXIS'],
            ['deskripsi_kuota' => '3. Axis Data BRONET 14 GB 30 hari', 'harga_kuota' => 53000, 'stok' => 5, 'harga_modal' => 51351, 'provider' => 'AXIS'],
            ['deskripsi_kuota' => 'Axis Data BRONET 30 GB 30 Hari', 'harga_kuota' => 88000, 'stok' => 11, 'harga_modal' => 85626, 'provider' => 'AXIS'],
            ['deskripsi_kuota' => 'Axis Data BRONET 35 GB 60 hari', 'harga_kuota' => 105000, 'stok' => 10, 'harga_modal' => 102421, 'harga_promo' => 104000, 'provider' => 'AXIS'],
            ['deskripsi_kuota' => 'Axis Data BRONET 75 GB 60 hari', 'harga_kuota' => 163000, 'stok' => 3, 'harga_modal' => 159335, 'provider' => 'AXIS'],
        ];

        foreach ($daftarKuota as $daftar) {
            DB::table('daftar_kuota')->insert([
                'deskripsi_kuota' => $daftar['deskripsi_kuota'],
                'harga_modal' => $daftar['harga_modal'],
                'harga_kuota' => $daftar['harga_kuota'],
                'harga_promo' => $daftar['harga_promo'] ?? null,
                'stok' => $daftar['stok'],
                'provider' => $daftar['provider'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
