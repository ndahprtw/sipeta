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
        Schema::create('lahans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_lahan');
            $table->string('nama_lahan');
            $table->foreignId('kategori_id')->references('id')->on('kategori_lahans')->onDelete('cascade');
            $table->foreignId('pemilik_id')->references('id')->on('pemiliks')->onDelete('cascade');
            $table->integer('luas');
            $table->string('status_verifikasi');
            $table->enum('status_lahan',['tersedia', 'terjual', 'dalam_proses']);
            $table->text('deskripsi');
            $table->foreignId('penanggung_jawab_id')->references('id')->on('staff')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lahans');
    }
};
