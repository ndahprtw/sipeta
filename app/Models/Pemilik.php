<?php

namespace App\Models;

use App\Models\Lahan;
use App\Models\RiwayatPemilik;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemilik extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik_pemilik',
        'nama_pemilik',
        'alamat',
    ];

    public function lahans()
    {
        return $this->hasMany(Lahan::class);
    }

    public function riwayatPemiliks()
    {
        return $this->hasMany(RiwayatPemilik::class);
    }

}
