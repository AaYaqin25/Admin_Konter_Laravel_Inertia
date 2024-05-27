<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarPulsa extends Model
{
    use HasFactory;

    protected $table = 'daftar_pulsa';

    protected $fillable = [
        'harga_pulsa',
        'harga_jual'
    ];

    public function penjualanPulsa()
    {
        return $this->hasMany(PenjualanPulsa::class);
    }
}
