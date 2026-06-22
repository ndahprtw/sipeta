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
        Schema::create('riwayat_pemiliks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lahan_id')->references('id')->on('lahans')->onDelete('cascade');
            $table->foreignId('pemilik_lama_id')->references('id')->on('pemiliks')->onDelete('cascade');
            $table->foreignId('pemilik_baru_id')->references('id')->on('pemiliks')->onDelete('cascade');
            $table->date('tanggal_peralihan');
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pemiliks');
    }
};
