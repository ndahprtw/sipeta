<?php

namespace Database\Seeders;

use App\Models\RiwayatPemilik;
use Illuminate\Database\Seeder;

class RiwayatPemilikSeeder extends Seeder
{
    public function run(): void
    {
        foreach (range(1, 15) as $lahanId) {

            RiwayatPemilik::create([
                'lahan_id' => $lahanId,
                'pemilik_id' => rand(1,8),
                'tanggal_mulai' => now()->subYears(rand(2, 5)),
                'tanggal_selesai' => null,
                'keterangan' => 'Pemilik aktif'
            ]);
        }
    }
}