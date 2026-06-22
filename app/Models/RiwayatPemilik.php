<?php

namespace App\Models;

use App\Models\Pemilik;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPemilik extends Model
{
    use HasFactory;

    protected $fillable = [
        'lahan_id',
        'pemilik_lama_id',
        'pemilik_baru_id',
        'tanggal_peralihan',
        'keterangan',
    ];

    public function pemilikLama()
    {
        return $this->belongsTo(Pemilik::class, 'pemilik_lama_id');
    }

    public function pemilikBaru()
    {
        return $this->belongsTo(Pemilik::class, 'pemilik_baru_id');
    }
}
