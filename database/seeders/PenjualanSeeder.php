<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'penjualan_id' => '001',
                'user_id' => 1,
                'penjualan_kode' => 'PJ001',
                'pembeli' => 'Agus Setiawan',
                'penjualan_tanggal' => '2024-09-01 10:30:00',
            ],
            [
                'penjualan_id' => '002',
                'user_id' => 2,
                'penjualan_kode' => 'PJ002',
                'pembeli' => 'Lestari Wulandari',
                'penjualan_tanggal' => '2024-09-01 11:00:00',
            ],
            [
                'penjualan_id' => '003',
                'user_id' => 3,
                'penjualan_kode' => 'PJ003',
                'pembeli' => 'Siti Nurhaliza',
                'penjualan_tanggal' => '2024-09-01 11:30:00',
            ],
            [
                'penjualan_id' => '004',
                'user_id' => 1,
                'penjualan_kode' => 'PJ004',
                'pembeli' => 'Rahmat Hidayat',
                'penjualan_tanggal' => '2024-09-02 09:15:00',
            ],
            [
                'penjualan_id' => '005',
                'user_id' => 2,
                'penjualan_kode' => 'PJ005',
                'pembeli' => 'Andi Susanto',
                'penjualan_tanggal' => '2024-09-02 10:00:00',
            ],
            [
                'penjualan_id' => '006',
                'user_id' => 3,
                'penjualan_kode' => 'PJ006',
                'pembeli' => 'Nurul Fadilah',
                'penjualan_tanggal' => '2024-09-02 11:45:00',
            ],
            [
                'penjualan_id' => '007',
                'user_id' => 1,
                'penjualan_kode' => 'PJ007',
                'pembeli' => 'Ahmad Fauzi',
                'penjualan_tanggal' => '2024-09-03 12:15:00',
            ],
            [
                'penjualan_id' => '008',
                'user_id' => 2,
                'penjualan_kode' => 'PJ008',
                'pembeli' => 'Dewi Sartika',
                'penjualan_tanggal' => '2024-09-03 13:00:00',
            ],
            [
                'penjualan_id' => '009',
                'user_id' => 3,
                'penjualan_kode' => 'PJ009',
                'pembeli' => 'Indra Lesmana',
                'penjualan_tanggal' => '2024-09-03 14:30:00',
            ],
            [
                'penjualan_id' => '010',
                'user_id' => 1,
                'penjualan_kode' => 'PJ010',
                'pembeli' => 'Fathir Hamdani',
                'penjualan_tanggal' => '2024-09-04 09:00:00',
            ],
            
        ];
        DB::table('t_penjualan')->insert($data);
    }
}
