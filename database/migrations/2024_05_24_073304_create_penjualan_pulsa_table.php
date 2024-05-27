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
        Schema::create('penjualan_pulsa', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nomor_pelanggan');
            $table->string('provider');
            $table->unsignedBigInteger('daftar_pulsa_id');
            $table->foreign('daftar_pulsa_id')->references('id')->on('daftar_pulsa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_pulsa');
    }
};
