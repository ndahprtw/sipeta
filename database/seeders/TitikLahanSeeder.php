<?php

namespace Database\Seeders;

use App\Models\TitikLahan;
use Illuminate\Database\Seeder;

class TitikLahanSeeder extends Seeder
{
    public function run(): void
    {
        $titik = [
            [
                'latitude' => -7.043250,
                'longitude' => 112.735100,
            ],
            [
                'latitude' => -7.043500,
                'longitude' => 112.735400,
            ],
            [
                'latitude' => -7.043900,
                'longitude' => 112.735200,
            ],
            [
                'latitude' => -7.043700,
                'longitude' => 112.734800,
            ],
        ];

        foreach ($titik as $index => $item) {

            TitikLahan::create([
                'lahan_id' => 1,
                'latitude' => $item['latitude'],
                'longitude' => $item['longitude'],
            ]);

        }
    }
}