<?php

namespace App\Http\Controllers;

use App\Models\PenjualanKuota;
use App\Models\PenjualanPulsa;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data penjualan bulanan untuk kuota dan pulsa
        $kuotaPerBulan = PenjualanKuota::selectRaw('MONTH(penjualan_kuota.created_at) as month, YEAR(penjualan_kuota.created_at) as year, SUM(COALESCE(daftar_kuota.harga_promo, daftar_kuota.harga_kuota)) as total')
            ->join('daftar_kuota', 'penjualan_kuota.daftar_kuota_id', '=', 'daftar_kuota.id')
            ->groupBy('year', 'month')
            ->get()
            ->pluck('total', 'month')
            ->all();

        $pulsaPerBulan = PenjualanPulsa::selectRaw('MONTH(penjualan_pulsa.created_at) as month, YEAR(penjualan_pulsa.created_at) as year, SUM(daftar_pulsa.harga_jual) as total')
            ->join('daftar_pulsa', 'penjualan_pulsa.daftar_pulsa_id', '=', 'daftar_pulsa.id')
            ->groupBy('year', 'month')
            ->get()
            ->pluck('total', 'month')
            ->all();

        // Hitung total penjualan dan keuntungan
        $totalPenjualanKuota = array_sum($kuotaPerBulan);
        $totalPenjualanPulsa = array_sum($pulsaPerBulan);
        $totalKeuntunganKuota = PenjualanKuota::with('daftarKuota')->get()->sum(function ($penjualan) {
            $hargaJual = $penjualan->daftarKuota->harga_promo ?? $penjualan->daftarKuota->harga_kuota;
            return $hargaJual - $penjualan->daftarKuota->harga_modal;
        });
        $totalKeuntunganPulsa = PenjualanPulsa::with('daftarPulsa')->get()->sum(function ($penjualan) {
            return $penjualan->daftarPulsa->harga_jual - $penjualan->daftarPulsa->harga_pulsa;
        });
        $totalKeuntungan = $totalKeuntunganKuota + $totalKeuntunganPulsa;

        return Inertia::render('Dashboard', [
            'kuotaPerBulan' => $kuotaPerBulan,
            'pulsaPerBulan' => $pulsaPerBulan,
            'penjualanKuota' => $totalPenjualanKuota,
            'penjualanPulsa' => $totalPenjualanPulsa,
            'keuntunganKuota' => $totalKeuntunganKuota,
            'keuntunganPulsa' => $totalKeuntunganPulsa,
            'totalKeuntungan' => $totalKeuntungan,
        ]);
    }
}
