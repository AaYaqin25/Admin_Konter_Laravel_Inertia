<?php

namespace App\Http\Controllers;

use App\Models\DaftarKuota;
use App\Models\PenjualanKuota;
use App\Models\SaldoPulsa;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KuotaController extends Controller
{
    public function index()
    {
        $penjualanKuota = PenjualanKuota::with('daftarKuota')->get();

        $tableData = $penjualanKuota->map(function ($penjualan) {
            return [
                "Id" => $penjualan->id,
                "Nomor Pelanggan" => $penjualan->nomor_pelanggan,
                "Provider" => $penjualan->daftarKuota->provider,
                'Deskripsi Kuota' => $penjualan->daftarKuota->deskripsi_kuota,
                "Harga Jual" => $penjualan->daftarKuota->harga_kuota,
                "Harga Promo" => $penjualan->daftarKuota->harga_promo ? $penjualan->daftarKuota->harga_promo : '-',
                "Stok" => $penjualan->daftarKuota->stok,
                "Tanggal Jual" => $penjualan->created_at
            ];
        });

        return Inertia::render('Penjualan/PenjualanKuota', ['tableData' => $tableData]);

    }

    public function jualKuota(Request $request)
    {
        $request->validate([
            'nomor_pelanggan' => 'required|string',
            'daftar_kuota_id' => 'required|exists:daftar_kuota,id',
        ]);

        // Ambil saldo terbaru
        $saldo = SaldoPulsa::latest()->first();

        // Ambil informasi kuota
        $kuota = DaftarKuota::findOrFail($request->daftar_kuota_id);
        $harga_kuota = $kuota->harga_promo ? $kuota->harga_promo : $kuota->harga_kuota;

        // Periksa apakah saldo mencukupi
        if ($saldo && $saldo->jumlah_saldo >= $harga_kuota) {
            // Periksa apakah stok mencukupi
            if ($kuota->stok > 0) {
                // Kurangi stok
                $kuota->update([
                    'stok' => $kuota->stok - 1
                ]);

                // Kurangi saldo
                $saldo->update([
                    'jumlah_saldo' => $saldo->jumlah_saldo - $harga_kuota
                ]);

                // Buat entri penjualan kuota baru
                PenjualanKuota::create([
                    'nomor_pelanggan' => $request->nomor_pelanggan,
                    'daftar_kuota_id' => $request->daftar_kuota_id,
                ]);

                // Redirect atau kirim respons sesuai kebutuhan
                return redirect()->back()->with('message', 'Penjualan kuota berhasil');
            } else {
                // Stok tidak mencukupi
                return redirect()->back()->withErrors(['message' => 'Stok tidak mencukupi untuk melakukan penjualan kuota']);
            }
        } else {
            // Saldo tidak mencukupi
            return redirect()->back()->withErrors(['message' => 'Saldo tidak mencukupi untuk melakukan penjualan kuota']);
        }
    }

    public function getKuotaOptions()
    {
        try {
            $kuotaOptions = DaftarKuota::all();
            return response()->json($kuotaOptions);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
