<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'supplier_id' => 1,
                'supplier_kode' => 001,
                'supplier_nama' => 'Sumber Healthy dan Beauty',
                'supplier_alamat' => 'Jakarta',
            ],
            [
                'supplier_id' => 2,
                'supplier_kode' => 002,
                'supplier_nama' => 'Serba Ada Shop',
                'supplier_alamat' => 'Malang',
            ],
            [
                'supplier_id' => 3,
                'supplier_kode' => 003,
                'supplier_nama' => 'Chin Elektronik',
                'supplier_alamat' => 'Surabaya',
            ],
        ];
        DB::table('m_supplier')->insert($data);
    }
}
