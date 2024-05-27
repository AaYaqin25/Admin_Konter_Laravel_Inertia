<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanKuota extends Model
{
    use HasFactory;

    protected $table = 'penjualan_kuota';

    protected $fillable = [
        'nomor_pelanggan',
        'daftar_kuota_id',
    ];

    public function daftarKuota()
    {
        return $this->belongsTo(DaftarKuota::class);
    }
}
