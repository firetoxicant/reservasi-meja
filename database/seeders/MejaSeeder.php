<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Meja;

class MejaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataMeja = [
            ['nama_meja' => 'Meja 01 (Indoor)', 'kapasitas_meja' => 2, 'status' => 'tersedia'],
            ['nama_meja' => 'Meja 02 (Indoor)', 'kapasitas_meja' => 2, 'status' => 'tersedia'],
            ['nama_meja' => 'Meja 03 (Indoor)', 'kapasitas_meja' => 4, 'status' => 'tersedia'],
            ['nama_meja' => 'Meja 04 (Indoor)', 'kapasitas_meja' => 4, 'status' => 'tersedia'],
            ['nama_meja' => 'Meja 05 (Indoor)', 'kapasitas_meja' => 6, 'status' => 'tersedia'],
            ['nama_meja' => 'Meja 06 (Family)', 'kapasitas_meja' => 8, 'status' => 'tersedia'],
            ['nama_meja' => 'Meja 07 (Outdoor)', 'kapasitas_meja' => 2, 'status' => 'tersedia'],
            ['nama_meja' => 'Meja 08 (Outdoor)', 'kapasitas_meja' => 4, 'status' => 'tersedia'],
            ['nama_meja' => 'Meja 09 (Outdoor)', 'kapasitas_meja' => 4, 'status' => 'tersedia'],
            ['nama_meja' => 'Meja 10 (VIP Room)', 'kapasitas_meja' => 10, 'status' => 'tersedia'],
        ];

        foreach ($dataMeja as $meja) {
            Meja::create($meja);
        }
    }
}
