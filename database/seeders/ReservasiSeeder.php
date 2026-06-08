<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservasi;
use App\Models\User;
use App\Models\Meja;
use Carbon\Carbon;
use Faker\Factory as Faker;

class ReservasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $idPelangganList = User::where('role', 'pelanggan')->pluck('id')->toArray();
        $idMejaList = Meja::pluck('id')->toArray();

        if (empty($idPelangganList) || empty($idMejaList)) {
            $this->command->warn('Gagal Seeding: Pastikan UserSeeder dan MejaSeeder sudah dijalankan!');
            return;
        }

        $pilihanJamMulai = ['11:00:00', '12:30:00', '13:00:00', '16:00:00', '18:00:00', '19:00:00', '19:30:00'];

        // Loop Bulan Januari (1) s.d Juni (6) 2026
        for ($bulan = 1; $bulan <= 6; $bulan++) {
            $jumlahTransaksiPerBulan = rand(6, 9);

            for ($i = 0; $i < $jumlahTransaksiPerBulan; $i++) {
                $hariAcak = rand(1, 28);
                $tanggalReservasi = Carbon::create(2026, $bulan, $hariAcak)->toDateString();

                $jamMulai = $faker->randomElement($pilihanJamMulai);
                $jamSelesai = Carbon::parse($jamMulai)->addHours(2)->toTimeString();
                $kodeReservasi = 'RSV-' . str_replace('-', '', $tanggalReservasi) . '-' . rand(1000, 9999);

                // 🌟 LOGIKA BARU: Hanya bulan 6 (Juni) dan indeks kelipatan 2 yang diatur 'belum lunas'
                if ($bulan === 6 && $i % 2 === 0) {
                    $statusReservasi = 'belum lunas';
                } else {
                    $statusReservasi = 'lunas';
                }

                Reservasi::create([
                    'kode_reservasi'    => $kodeReservasi,
                    'id_pelanggan'      => $faker->randomElement($idPelangganList),
                    'id_meja'           => $faker->randomElement($idMejaList),
                    'jam_mulai'         => $jamMulai,
                    'jam_selesai'       => $jamSelesai,
                    'tanggal_reservasi' => $tanggalReservasi,
                    'bukti'             => 'uploads/downpayment/dummy_proof.png',
                    'status_reservasi'  => $statusReservasi,
                    'created_at'        => Carbon::create(2026, $bulan, $hariAcak, rand(9, 21), rand(0, 59)),
                    'updated_at'        => Carbon::create(2026, $bulan, $hariAcak, rand(9, 21), rand(0, 59)),
                ]);
            }
        }
    }
}