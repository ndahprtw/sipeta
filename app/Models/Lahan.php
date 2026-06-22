<?php

namespace App\Models;

use App\Models\FotoLahan;
use App\Models\KategoriLahan;
use App\Models\Pemilik;
use App\Models\RiwayatPemilik;
use App\Models\TitikLahan;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lahan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_lahan',
        'nama_lahan',
        'kategori_id',
        'pemilik_id',
        'luas',
        'status_verifikasi',
        'status_lahan',
        'deskripsi',
        'penanggung_jawab_id',
    ];

    public function petugas()
    {
        return $this->belongsTo(Staff::class, 'penanggung_jawab_id');
    }

    public function pemilik()
    {
        return $this->belongsTo(Pemilik::class);
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriLahan::class, 'kategori_id');
    }

    public function titikLahans()
    {
        return $this->hasMany(TitikLahan::class);
    }

    public function fotoLahans()
    {
        return $this->hasMany(FotoLahan::class);
    }

    public function riwayatPemiliks()
    {
        return $this->hasMany(RiwayatPemilik::class);
    }
}
