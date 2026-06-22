<?php

namespace Database\Seeders;

use App\Models\RiwayatPemilik;
use Illuminate\Database\Seeder;

class RiwayatPemilikSeeder extends Seeder
{
    public function run(): void
    {
        RiwayatPemilik::create([
            'lahan_id' => 1,
            'pemilik_lama_id' => 1,
            'pemilik_baru_id' => 2,
            'tanggal_peralihan' => '2024-01-15',
            'keterangan' => 'Jual beli lahan',
        ]);

        RiwayatPemilik::create([
            'lahan_id' => 1,
            'pemilik_lama_id' => 2,
            'pemilik_baru_id' => 3,
            'tanggal_peralihan' => '2025-03-10',
            'keterangan' => 'Peralihan hak kepemilikan',
        ]);

        RiwayatPemilik::create([
            'lahan_id' => 2,
            'pemilik_lama_id' => 4,
            'pemilik_baru_id' => 5,
            'tanggal_peralihan' => '2024-08-21',
            'keterangan' => 'Jual beli lahan',
        ]);

        RiwayatPemilik::create([
            'lahan_id' => 3,
            'pemilik_lama_id' => 6,
            'pemilik_baru_id' => 7,
            'tanggal_peralihan' => '2025-01-05',
            'keterangan' => 'Hibah keluarga',
        ]);

        RiwayatPemilik::create([
            'lahan_id' => 4,
            'pemilik_lama_id' => 7,
            'pemilik_baru_id' => 8,
            'tanggal_peralihan' => '2025-09-12',
            'keterangan' => 'Jual beli lahan',
        ]);
    }
}