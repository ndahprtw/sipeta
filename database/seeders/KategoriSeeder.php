<?php

namespace Database\Seeders;

use App\Models\KategoriLahan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            [
                'nama_kategori' => 'Sawah',
                'warna' => '#28a745',
                'deskripsi' => 'Lahan pertanian padi'
            ],
            [
                'nama_kategori' => 'Perkebunan',
                'warna' => '#ffc107',
                'deskripsi' => 'Lahan perkebunan'
            ],
            [
                'nama_kategori' => 'Perumahan',
                'warna' => '#dc3545',
                'deskripsi' => 'Lahan pemukiman'
            ],
            [
                'nama_kategori' => 'Tanah Kosong',
                'warna' => '#6c757d',
                'deskripsi' => 'Belum dimanfaatkan'
            ]
        ];

            foreach ($kategori as $item) {
            KategoriLahan::create($item);
        }

    }
}
