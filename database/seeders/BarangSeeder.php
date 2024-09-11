<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'barang_id' => 1,
                'kategori_id' => 1,
                'barang_kode' => 'E01',
                'barang_nama' => 'Lampu LED Philips 9W',
                'harga_beli' => 20000,
                'harga_jual' => 25000
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 1,
                'barang_kode' => 'E02',
                'barang_nama' => 'Kabel HDMI 1.5 Meter',
                'harga_beli' => 20000,
                'harga_jual' => 35000
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 1,
                'barang_kode' => 'E03',
                'barang_nama' => 'Charger USB Anker 18W',
                'harga_beli' => 30000,
                'harga_jual' => 40000
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 4,
                'barang_kode' => 'M01',
                'barang_nama' => 'Mie Instan Indomie Goreng',
                'harga_beli' => 2500,
                'harga_jual' => 3000
            ],
            [
                'barang_id' => 5,
                'kategori_id' => 4,
                'barang_kode' => 'M02',
                'barang_nama' => 'Susu UHT Frisian Flag 1L',
                'harga_beli' => 12000,
                'harga_jual' => 15000
            ],
            [
                'barang_id' => 6,
                'kategori_id' => 4,
                'barang_kode' => 'M03',
                'barang_nama' => 'Keripik Singkong Balado',
                'harga_beli' => 7000,
                'harga_jual' => 10000
            ],
            [
                'barang_id' => 7,
                'kategori_id' => 5,
                'barang_kode' => 'P01',
                'barang_nama' => 'Kaos Polos Hitam',
                'harga_beli' => 25000,
                'harga_jual' => 50000
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 5,
                'barang_kode' => 'P02',
                'barang_nama' => 'Blouse Wanita Batik',
                'harga_beli' => 50000,
                'harga_jual' => 70000
            ],
            [
                'barang_id' => 9,
                'kategori_id' => 5,
                'barang_kode' => 'P03',
                'barang_nama' => 'Sneakers Converse',
                'harga_beli' => 250000,
                'harga_jual' => 350000
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 2,
                'barang_kode' => 'K01',
                'barang_nama' => 'Lipstik Wardah Matte',
                'harga_beli' => 25000,
                'harga_jual' => 35000
            ],
            [
                'barang_id' => 11,
                'kategori_id' => 2,
                'barang_kode' => 'K02',
                'barang_nama' => 'Facial Wash Garnier',
                'harga_beli' => 15000,
                'harga_jual' => 25000
            ],
            [
                'barang_id' => 12,
                'kategori_id' => 2,
                'barang_kode' => 'K03',
                'barang_nama' => 'Body Lotion Vaseline',
                'harga_beli' => 250000,
                'harga_jual' => 350000
            ],
            [
                'barang_id' => 13,
                'kategori_id' => 3,
                'barang_kode' => 'O01',
                'barang_nama' => 'Paracetamol 500mg',
                'harga_beli' => 500,
                'harga_jual' => 1000
            ],
            [
                'barang_id' => 14,
                'kategori_id' => 3,
                'barang_kode' => 'O02',
                'barang_nama' => 'Vitamin C 500mg',
                'harga_beli' => 2000,
                'harga_jual' => 3000
            ],
            [
                'barang_id' => 15,
                'kategori_id' => 3,
                'barang_kode' => 'O03',
                'barang_nama' => 'Amoxicillin 500mg',
                'harga_beli' => 1000,
                'harga_jual' => 2000
            ],
        ];
        DB::table('m_barang')->insert($data);
    }
}
