<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use  App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        // 1. Data Admin
        User::create([
            'nama_lengkap' => 'Edie Feeding Frenzy',
            'username'     => 'edie',
            'email'        => 'admin@gmail.com',
            'password'     => Hash::make('admin123'), // Anda bisa mengganti password default ini
            'role'         => 'admin',
        ]);

        // 2. Data Kasir
        User::create([
            'nama_lengkap' => 'Raihan Wijayadi',
            'username'     => 'raihanwijay',
            'email'        => 'kasir@gmail.com',
            'password'     => Hash::make('kasir123'),
            'role'         => 'kasir',
        ]);

        // 3. Data Pelanggan 1
        User::create([
            'nama_lengkap' => 'Krisna Jauhari',
            'username'     => 'krisnajauhara',
            'email'        => 'kasir2@gmail.com',
            'password'     => Hash::make('kasir123'),
            'role'         => 'kasir',
        ]);

        // 4. Data Pelanggan 2
        User::create([
            'nama_lengkap' => 'William',
            'username'     => 'william',
            'email'        => 'pelanggan@gmail.com',
            'password'     => Hash::make('pelanggan123'),
            'role'         => 'pelanggan',
        ]);

        User::create([
            'nama_lengkap' => 'Arif Gedangan',
            'username'     => 'Arif Tuwir',
            'email'        => 'pelanggan2@gmail.com',
            'password'     => Hash::make('pelanggan123'),
            'role'         => 'pelanggan',
        ]);
    }
}
