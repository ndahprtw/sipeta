<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoLahan extends Model
{
    use HasFactory;

    protected $fillable = [
        'lahan_id',
        'foto',
        'keterangan',
    ];

}
