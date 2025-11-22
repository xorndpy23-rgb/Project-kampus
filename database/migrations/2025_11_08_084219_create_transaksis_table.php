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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('program_zakats')->onDelete('cascade');
            $table->string('nama');
            $table->string('email');
            $table->string('nomor_hp')->nullable();
            $table->bigInteger('jumlah');
            $table->string('kode_transaksi')->unique();
            $table->string('snap_token')->nullable();
            $table->enum('status_pembayaran', ['TERTUNDA', 'BERHASIL', 'GAGAL', 'KEDALUWARSA'])->default('TERTUNDA');
            $table->string('metode_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
