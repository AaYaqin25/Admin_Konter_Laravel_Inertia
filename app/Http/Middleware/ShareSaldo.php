<?php

namespace App\Http\Middleware;

use App\Models\SaldoPulsa;
use Inertia\Middleware;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShareSaldo extends Middleware
{
    public function handle(Request $request, Closure $next)
    {
        // Get the latest saldo
        $saldo = SaldoPulsa::latest()->first();
        $saldoAmount = $saldo ? $saldo->jumlah_saldo : 0;

        // Share the saldo with Inertia
        Inertia::share('saldo', $saldoAmount);

        return $next($request);
    }
}
