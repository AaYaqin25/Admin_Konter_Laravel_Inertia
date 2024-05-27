<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarKuota extends Model
{
    use HasFactory;

    protected $table = 'daftar_kuota';

    protected $fillable = [
        'deskripsi_kuota',
        'harga_kuota',
        'harga_promo',
        'harga_modal',
        'provider',
        'stok'
    ];

    public function penjualanKuota()
    {
        return $this->hasMany(PenjualanKuota::class);
    }
}
