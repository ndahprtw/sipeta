<?php

namespace App\Models;

use App\Models\Lahan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriLahan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kategori',
        'warna',
        'deskripsi',
    ];

    public function lahans()
    {
        return $this->hasMany(Lahan::class, 'kategori_id');
    }
}
