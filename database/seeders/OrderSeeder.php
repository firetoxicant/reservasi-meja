<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Reservasi;
use App\Models\Menu;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Ambil semua data reservasi dan menu yang sudah di-seed sebelumnya
        $reservasiList = Reservasi::all();
        $menuList = Menu::all();

        if ($reservasiList->isEmpty() || $menuList->isEmpty()) {
            $this->command->warn('Gagal Seeding: Pastikan MenuSeeder dan ReservasiSeeder sudah dijalankan!');
            return;
        }

        // 2. Iterasi setiap reservasi untuk diberikan item pesanan menu
        foreach ($reservasiList as $reservasi) {
            
            // Setiap meja memesan 1 sampai 3 variasi menu acak
            $jumlahVariasiMenu = rand(1, 3);
            // Mengacak menu tanpa ada menu ganda di dalam 1 reservasi yang sama
            $menuAcak = $menuList->random($jumlahVariasiMenu);

            foreach ($menuAcak as $menu) {
                $jumlahPorsi = rand(1, 3); // Jumlah porsi per makanan (1-3 porsi)
                $subTotal = $menu->harga * $jumlahPorsi; // Hitung otomatis nominal sub_total

                Order::create([
                    'id_reservasi' => $reservasi->id,
                    'id_menu'      => $menu->id,
                    'jumlah'       => $jumlahPorsi,
                    'sub_total'    => $subTotal,
                    // Disamakan dengan waktu pembuatan reservasi agar sinkron saat difilter grafik
                    'created_at'   => $reservasi->created_at,
                    'updated_at'   => $reservasi->updated_at,
                ]);
            }
        }
    }
}
