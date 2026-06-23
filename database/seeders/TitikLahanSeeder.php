<?php

namespace Database\Seeders;

use App\Models\TitikLahan;
use Illuminate\Database\Seeder;

class TitikLahanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
        // Lahan 1
            [
                'lahan_id' => 1,
                'latitude' => -7.030895,
                'longitude' => 112.752992,
            ],
            [
                'lahan_id' => 1,
                'latitude' => -7.030916,
                'longitude' => 112.752994,
            ],
            [
                'lahan_id' => 1,
                'latitude' => -7.030913,
                'longitude' => 112.752940,
            ],
            [
                'lahan_id' => 1,
                'latitude' => -7.030888,
                'longitude' => 112.752939,
            ],

            // Lahan 2
            [
                'lahan_id' => 2,
                'latitude' => -7.030908,
                'longitude' => 112.753087,
            ],
            [
                'lahan_id' => 2,
                'latitude' => -7.03093829,
                'longitude' => 112.75318305,
            ],
            [
                'lahan_id' => 2,
                'latitude' => -7.030980,
                'longitude' => 112.753064,
            ],
            // [
            //     'lahan_id' => 2,
            //     'latitude' => -7.03101218,
            //     'longitude' => 112.75316141,
            // ],
        ];

        foreach ($data as $item) {
            TitikLahan::create($item);
        }
    }
}