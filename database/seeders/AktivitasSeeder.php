<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AktivitasSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $data = [
            [
                'aktivitas' => 'Admin menambahkan kategori lahan Sawah',
                'created_at' => $now->copy()->subMinutes(45),
                'updated_at' => $now->copy()->subMinutes(45),
            ],
            [
                'aktivitas' => 'Petugas menambahkan data lahan milik Budi',
                'created_at' => $now->copy()->subMinutes(40),
                'updated_at' => $now->copy()->subMinutes(40),
            ],
            [
                'aktivitas' => 'Petugas 2 memperbarui data lahan L-001',
                'created_at' => $now->copy()->subMinutes(35),
                'updated_at' => $now->copy()->subMinutes(35),
            ],
            [
                'aktivitas' => 'Petugas menambahkan polygon pada lahan L-002',
                'created_at' => $now->copy()->subMinutes(30),
                'updated_at' => $now->copy()->subMinutes(30),
            ],
            [
                'aktivitas' => 'Petugas 2 menghapus data lahan L-003',
                'created_at' => $now->copy()->subMinutes(25),
                'updated_at' => $now->copy()->subMinutes(25),
            ],
        ];

        DB::table('activities')->insert($data);
    }
}