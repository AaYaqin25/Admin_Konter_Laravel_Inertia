<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaldoPulsa;
use Inertia\Inertia;

class SaldoController extends Controller
{
    public function index()
    {
        $saldoData = SaldoPulsa::all(); // Mengambil semua entri dari tabel

        $tableData = [];

        foreach ($saldoData as $saldo) {
            $tableData[] = [
                "Id" => $saldo->id,
                "Saldo Dibeli" => $saldo->saldo_dibeli,
                'Jumlah Saldo' => $saldo->jumlah_saldo,
                "Tanggal Beli" => $saldo->created_at
            ];
        }

        return Inertia::render('Pembelian/PembelianPulsa', ['tableData' => $tableData]);
    }
    public function buySaldo(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        // Ambil saldo terbaru jika ada
        $saldo = SaldoPulsa::latest()->first();

        // Hitung jumlah saldo yang baru
        $jumlahSaldoBaru = $saldo ? $saldo->jumlah_saldo + $request->jumlah : $request->jumlah;

        // Buat entri baru dengan data yang sudah dihitung
        SaldoPulsa::create([
            'saldo_dibeli' => $request->jumlah,
            'jumlah_saldo' => $jumlahSaldoBaru
        ]);

        return redirect()->back()->with('message', 'Saldo berhasil ditambahkan');
    }
}
