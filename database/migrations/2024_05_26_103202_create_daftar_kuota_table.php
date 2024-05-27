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
        Schema::create('daftar_kuota', function (Blueprint $table) {
            $table->id();
            $table->text('deskripsi_kuota');
            $table->unsignedBigInteger('harga_modal');
            $table->unsignedBigInteger('harga_kuota');
            $table->unsignedBigInteger('harga_promo')->nullable();
            $table->unsignedBigInteger('stok');
            $table->string('provider');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_kuota');
    }
};
