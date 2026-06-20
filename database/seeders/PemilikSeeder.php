<?php

namespace Database\Seeders;

use App\Models\Pemilik;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PemilikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 8; $i++) {

            Pemilik::create([
                'nik_pemilik' => '35260' . rand(1000000000, 9999999999),
                'nama_pemilik' => collect([
                    'Ahmad',
                    'Budi',
                    'Siti',
                    'Andi',
                    'Rina',
                    'Fajar',
                    'Dewi',
                    'Rudi',
                ])->random(),
                'alamat' => collect([
                    'Kecamatan Kamal',
                    'Kecamatan Socah',
                    'Kecamatan Burneh',
                    'Kecamatan Tanah Merah',
                ])->random(),
            ]);
        }
    }
}
