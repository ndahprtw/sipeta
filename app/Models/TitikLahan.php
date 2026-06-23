<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitikLahan extends Model
{
    use HasFactory;

    protected $fillable = [
        'lahan_id',
        'latitude',
        'longitude',
    ];
}
