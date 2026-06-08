<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use App\Models\User;
use App\Models\Order;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua data reservasi
        $reservasiList = Reservasi::all();
        
        // Ambil ID kasir default untuk transaksi yang lunas normal
        $idKasirDefault = User::where('role', 'kasir')->first()?->id ?? 1;

        foreach ($reservasiList as $reservasi) {
            
            // Hitung total_awal secara dinamis dari akumulasi sub_total di tabel orders
            $totalAwal = Order::where('id_reservasi', $reservasi->id)->sum('sub_total');

            if ($totalAwal == 0) {
                $totalAwal = rand(50000, 150000);
            }

            // 🌟 LOGIKA UTAMA: Cek status dari tabel reservasi induknya
            if ($reservasi->status_reservasi === 'belum lunas') {
                
                // --- SKENARIO A: RESERVASI BELUM LUNAS (HANYA AKAN TERJADI DI DATA BULAN 6) ---
                $dp = $totalAwal * 0.5;   // Nilai uang muka 50%
                $bayar = $dp;             // Kolom bayar sama dengan nominal DP (artinya belum lunas)
                $kembali = 0;             
                
                // Hubungkan id_kasir langsung dengan id_pelanggan
                $idKasirFinal = $reservasi->id_pelanggan;

            } else {
                
                // --- SKENARIO B: RESERVASI LUNAS (UNTUK BULAN 1-5 & SEBAGIAN BULAN 6) ---
                $dp = $totalAwal * 0.5;   
                $bayar = $totalAwal;      // Uang diserahkan lunas penuh
                $kembali = $bayar - $totalAwal; 
                
                $idKasirFinal = $idKasirDefault;

            }

            Pembayaran::create([
                'id_reservasi' => $reservasi->id,
                'total_awal'   => $totalAwal,
                'dp'           => $dp,
                'bayar'        => $bayar,
                'kembali'      => $kembali,
                'id_pelanggan' => $reservasi->id_pelanggan,
                'id_kasir'     => $idKasirFinal,
                'created_at'   => $reservasi->created_at,
                'updated_at'   => $reservasi->updated_at,
            ]);
        }
    }
}