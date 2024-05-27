<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualan_kuota', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pelanggan');
            $table->unsignedBigInteger('daftar_kuota_id');
            $table->foreign('daftar_kuota_id')->references('id')->on('daftar_kuota')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_kuota');
    }
};
