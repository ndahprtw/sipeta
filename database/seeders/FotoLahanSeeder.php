<?php

namespace Database\Seeders;

use App\Models\FotoLahan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FotoLahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FotoLahan::create([
            'lahan_id' => 1,
            'foto' => 'foto-1.jpg',
            'keterangan' => 'Tampak depan lahan',
        ]);

        FotoLahan::create([
            'lahan_id' => 1,
            'foto' => 'foto-2.jpeg',
            'keterangan' => 'Tampak samping lahan',
        ]);
    }
}
