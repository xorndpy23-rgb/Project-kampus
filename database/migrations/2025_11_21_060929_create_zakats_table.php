<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('zakats', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->string('nama');
            $table->string('email');
            $table->string('phone');
            $table->enum('jenis_zakat', ['mal', 'fitrah', 'infaq']);
            $table->string('sumber_harta')->nullable();
            $table->decimal('jumlah_harta', 15, 2)->nullable();
            $table->decimal('nominal', 15, 2);
            $table->text('catatan')->nullable();
            $table->string('snap_token')->nullable();
            $table->enum('status', ['pending', 'success', 'failed', 'expired'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('zakats');
    }
};