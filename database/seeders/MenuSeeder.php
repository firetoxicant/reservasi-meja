<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataMenu = [
            // --- KATEGORI MAKANAN ---
            [
                'nama_menu' => 'Ayam Goreng Kremes',
                'kategori'  => 'makanan',
                'harga'     => 25000,
                'deskripsi' => 'Ayam goreng kremes disajikan dengan sambal bajak dan lalapan.',
                'stok'    => 20,
                'status'    => 'tersedia'
            ],
            [
                'nama_menu' => 'Bebek Goreng Sambal Matah',
                'kategori'  => 'makanan',
                'harga'     => 35000,
                'deskripsi' => 'Bebek goreng dengan sambal matah khas Bali.',
                'stok'    => 20,
                'status'    => 'tersedia'
            ],
            [
                'nama_menu' => 'Mie Goreng Jawa',
                'kategori'  => 'makanan',
                'harga'     => 18000,
                'deskripsi' => 'Mie kuning basah dimasak dengan bumbu tradisional Jawa, sayuran, dan telur acak.',
                'stok'    => 20,
                'status'    => 'tersedia'
            ],
            [
                'nama_menu' => 'Sate Ayam Madura',
                'kategori'  => 'makanan',
                'harga'     => 22000,
                'deskripsi' => '10 tusuk sate ayam empuk bumbu kacang gurih khas Madura.',
                'stok'    => 20,
                'status'    => 'tersedia'
            ],
            [
                'nama_menu' => 'Cumi Goreng Tepung',
                'kategori'  => 'makanan',
                'harga'     => 30000,
                'deskripsi' => 'Cumi segar digoreng krispi dengan balutan tepung bumbu rempah rahasia.',
                'stok'    => 20,
                'status'    => 'tersedia'
            ],

            // --- KATEGORI MINUMAN ---
            [
                'nama_menu' => 'Es Teh Manis',
                'kategori'  => 'minuman',
                'harga'     => 5000,
                'deskripsi' => 'Teh manis melati segar disajikan dingin dengan es batu.',
                'stok'    => 20,
                'status'    => 'tersedia'
            ],
            [
                'nama_menu' => 'Es Jeruk Peras',
                'kategori'  => 'minuman',
                'harga'     => 7000,
                'deskripsi' => 'Perasan jeruk lokal asli segar kaya akan vitamin C.',
                'stok'    => 20,
                'status'    => 'tersedia'
            ],
            [
                'nama_menu' => 'Jus Alpukat',
                'kategori'  => 'minuman',
                'harga'     => 12000,
                'deskripsi' => 'Jus buah alpukat kental dengan siraman susu kental manis cokelat.',
                'stok'    => 20,
                'status'    => 'tersedia'
            ],
            [
                'nama_menu' => 'Soda Gembira',
                'kategori'  => 'minuman',
                'harga'     => 15000,
                'deskripsi' => 'Perpaduan air soda, sirup coco pandan merah, dan susu kental manis.',
                'stok'    => 20,
                'status'    => 'tersedia'
            ],
            [
                'nama_menu' => 'Kopi Susu Gula Aren',
                'kategori'  => 'minuman',
                'harga'     => 14000,
                'deskripsi' => 'Espresso blend dengan susu segar dan manisnya gula aren murni.',
                'stok'    => 20,
                'status'    => 'tersedia'
            ],
        ];

        // Memasukkan seluruh data ke database menggunakan Model Menu
        foreach ($dataMenu as $menu) {
            Menu::create($menu);
        }
    }
}
