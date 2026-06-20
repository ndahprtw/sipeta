<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\PemilikSeeder;
use Database\Seeders\PemilikSeeder as SeedersPemilikSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            StaffSeeder::class,
            LokasiBidangSeeder::class,
            TitikLokasiSeeder::class,

            KategoriSeeder::class,
            SeedersPemilikSeeder::class,
            LahanSeeder::class,
            RiwayatPemilikSeeder::class
          ]);  
          
    }
}
