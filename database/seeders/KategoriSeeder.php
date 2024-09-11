<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kategori_id' => 1,
                'kategori_kode' => 'EK',
                'kategori_nama' => 'Elektronik',
                
            ],
            [
                'kategori_id' => 2,
                'kategori_kode' => 'KC',
                'kategori_nama' => 'Kecantikan',
            ],
            [
                'kategori_id' => 3,
                'kategori_kode' => 'OB',
                'kategori_nama' => 'Obat-obatan',
            ],
            [
                'kategori_id' => 4,
                'kategori_kode' => 'MM',
                'kategori_nama' => 'Makanan dan Minuman',
            ],
            [
                'kategori_id' => 5,
                'kategori_kode' => 'PK',
                'kategori_nama' => 'Pakaian',
            ],
        ];
        DB::table('m_kategori')->insert($data);
    }
}
