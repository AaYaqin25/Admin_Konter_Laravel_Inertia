<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanPulsa extends Model
{
    use HasFactory;

    protected $table = 'penjualan_pulsa';

    protected $fillable = [
        'nomor_pelanggan',
        'daftar_pulsa_id',
        'provider',
    ];
    public function daftarPulsa()
    {
        return $this->belongsTo(DaftarPulsa::class);
    }
}
