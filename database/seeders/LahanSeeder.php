<?php

namespace Database\Seeders;

use App\Models\Lahan;
use Illuminate\Database\Seeder;

class LahanSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 15; $i++) {

            Lahan::create([
                'kode_lahan' => 'LHN-' . date('Y') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nama_lahan' => 'Lahan ' . $i,
                'pemilik_id' => rand(1,8),
                'kategori_id' => rand(1, 4),
                'luas' => rand(500, 5000),
                'status_verifikasi' => collect([
                    'menunggu',
                    'disetujui',
                    'ditolak'
                ])->random(),
                'status_lahan' => collect([
                    'tersedia',
                    'dijual',
                    'dalam proses'
                ])->random(),
                'deskripsi' => 'Data lahan SIPETA',
                'penanggung_jawab_id' => rand(2,3),
                // 'verified_by' => rand(1, 2),
                // 'verified_at' => now(),
            ]);
        }
    }
}