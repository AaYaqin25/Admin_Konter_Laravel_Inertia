<?php

namespace App\Http\Controllers;

use App\Models\DaftarPulsa;
use App\Models\PenjualanPulsa;
use App\Models\SaldoPulsa;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PulsaController extends Controller
{
    public function index()
    {
        $penjualanPulsa = PenjualanPulsa::with('daftarPulsa')->get();

        $tableData = $penjualanPulsa->map(function ($penjualan) {
            return [
                "Id" => $penjualan->id,
                "Nomor Pelanggan" => $penjualan->nomor_pelanggan,
                "Provider" => $penjualan->provider,
                'Pulsa' => $penjualan->daftarPulsa->harga_pulsa,
                "Harga Jual" => $penjualan->daftarPulsa->harga_jual,
                "Tanggal Jual" => $penjualan->created_at
            ];
        });

        return Inertia::render('Penjualan/PenjualanPulsa', ['tableData' => $tableData]);
    }

    public function jualPulsa(Request $request)
    {
        $request->validate([
            'nomor_pelanggan' => 'required|string',
            'daftar_pulsa_id' => 'required|exists:daftar_pulsa,id',
            'provider' => 'required|string'
        ]);

        // Ambil saldo terbaru
        $saldo = SaldoPulsa::latest()->first();

        // Ambil harga pulsa
        $pulsa = DaftarPulsa::findOrFail($request->daftar_pulsa_id);
        $harga_pulsa = $pulsa->harga_pulsa;

        // Periksa apakah saldo mencukupi
        if ($saldo && $saldo->jumlah_saldo >= $harga_pulsa) {
            // Kurangi saldo
            $saldo->update([
                'jumlah_saldo' => $saldo->jumlah_saldo - $harga_pulsa
            ]);

            // Buat entri penjualan pulsa baru
            PenjualanPulsa::create([
                'nomor_pelanggan' => $request->nomor_pelanggan,
                'daftar_pulsa_id' => $request->daftar_pulsa_id,
                'provider' => $request->provider
            ]);

            // Redirect atau kirim respons sesuai kebutuhan
            return redirect()->back()->with('message', 'Penjualan pulsa berhasil');
        } else {
            // Saldo tidak mencukupi
            return redirect()->back()->withErrors(['message' => 'Saldo tidak mencukupi untuk melakukan penjualan pulsa']);
        }
    }



    public function getPulsaOptions()
    {
        try {
            $pulsaOptions = DaftarPulsa::all();
            return response()->json($pulsaOptions);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
