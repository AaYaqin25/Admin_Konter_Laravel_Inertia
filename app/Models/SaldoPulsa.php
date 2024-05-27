<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoPulsa extends Model
{
    use HasFactory;

    protected $table = 'saldo_pulsa';

    protected $fillable = [
        'saldo_dibeli',
        'jumlah_saldo'
    ];
}

