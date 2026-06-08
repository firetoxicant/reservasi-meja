<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Order;
use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->role == 'admin') {
            $pendapatanBulanan = Pembayaran::selectRaw('MONTH(created_at) as bulan, SUM(total_awal) as total')
            ->whereColumn('bayar', '>=', 'total_awal') // Kondisi Lunas
            ->whereYear('created_at', date('Y'))
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('bulan', 'asc')
            ->get();
    
            // Inisialisasi array untuk 12 bulan (Jan - Des) dengan nilai awal 0
            $labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $dataPendapatan = array_fill(0, 12, 0);
    
            // Memasukkan data dari database ke bulan yang sesuai
            foreach ($pendapatanBulanan as $item) {
                $dataPendapatan[$item->bulan - 1] = (int) $item->total;
            }
    
            //top 5 menu terlaris
            // Mengambil 5 menu terlaris yang paling banyak dipesan pelanggan
            $menuTerjual = Order::selectRaw('id_menu, SUM(jumlah) as total_porsi')
            ->whereHas('menu', function($query) {
                $query->where('kategori', 'makanan');
            })
            ->groupBy('id_menu')
            ->orderBy('total_porsi', 'desc')
            ->take(5)
            ->with('menu') // Mengambil data nama_menu dari relasi Model Menu
            ->get();
    
            // Pisahkan menjadi array untuk kebutuhan label dan data Chart.js
            $labelsMenu = [];
            $dataPorsi = [];
    
            foreach ($menuTerjual as $item) {
                $labelsMenu[] = $item->menu ? $item->menu->nama_menu : 'Menu Tidak Diketahui';
                $dataPorsi[] = (int) $item->total_porsi;
            }
    
            //jam reservasi terbanyak
            $jamSibuk = Reservasi::selectRaw("DATE_FORMAT(jam_mulai, '%H:%i') as jam, COUNT(*) as total_reservasi")
                ->groupByRaw("DATE_FORMAT(jam_mulai, '%H:%i')")
                ->orderBy('jam', 'asc')
                ->get();
    
            $labelsJam = [];
            $dataJumlahReservasi = [];
    
            foreach ($jamSibuk as $item) {
                $labelsJam[] = str_pad($item->jam, 2, '0', STR_PAD_LEFT);
                $dataJumlahReservasi[] = $item->total_reservasi;
            }

            //reservasi hari ini
            // Ambil tanggal hari ini menggunakan Carbon
            $hariIni = Carbon::today()->toDateString(); // Menghasilkan format 'YYYY-MM-DD'

            // 1. Menghitung JUMLAH TOTAL reservasi yang dibuat untuk JADWAL hari ini
            $reservasiHariIni = Reservasi::whereDate('tanggal_reservasi', $hariIni)->count();

            // 2. TOTAL OMZET/PENDAPATAN masuk khusus hari ini
            $pendapatanHariIni = Pembayaran::whereDate('created_at', $hariIni)
                ->whereColumn('bayar', '>=', 'total_awal')
                ->sum('total_awal');
    
            return view('dashboard.index', compact('labels', 'dataPendapatan', 'labelsMenu', 'dataPorsi', 'labelsJam', 'dataJumlahReservasi', 'reservasiHariIni', 'pendapatanHariIni'));
        }elseif(auth()->user()->role === 'kasir') {
            $hariIni = Carbon::today()->toDateString();
            $idKasirLogined = Auth::id(); // Mengambil ID Kasir yang sedang login saat ini

            // 1. Total reservasi umum yang dijadwalkan DATANG hari ini (untuk info kesiapan resto)
            $totalReservasiDatangHariIni = Reservasi::whereDate('tanggal_reservasi', $hariIni)->count();

            // 2. TOTAL RESERVASI YANG DITANGANI oleh kasir ini hari ini
            // Dihitung dari berapa banyak data di tabel pembayaran yang diinput oleh id_kasir tersebut hari ini
            $reservasiDitanganiKasir = Pembayaran::whereDate('created_at', $hariIni)
                ->where('id_kasir', $idKasirLogined)
                ->count();

            // 3. TOTAL UANG MASUK yang dikumpulkan oleh kasir ini hari ini (Uang Fisik + DP masuk di shift dia)
            // Menghitung jumlah kolom 'bayar' (bukan total_awal) karena 'bayar' melambangkan uang tunai/transfer yang benar-benar diterima kasir saat itu
            $uangMasukKasir = Pembayaran::whereDate('created_at', $hariIni)
                ->where('id_kasir', $idKasirLogined)
                ->sum('bayar');

            return view('dashboard.index', compact(
                'totalReservasiDatangHariIni',
                'reservasiDitanganiKasir',
                'uangMasukKasir'
            ));
        }else{
            $idPelanggan = Auth::id();
            $hariIni = Carbon::today()->toDateString();

            // 1. Hitung reservasi aktif yang akan datang (hari ini ke depan)
            $bookingAktif = Reservasi::where('id_pelanggan', $idPelanggan)
                ->whereDate('tanggal_reservasi', '>=', $hariIni)
                ->count();

            // 2. Total seluruh riwayat kunjungan yang pernah dilakukan
            $totalKunjungan = Reservasi::where('id_pelanggan', $idPelanggan)
                ->where('status_reservasi', 'lunas')
                ->count();

            // 3. Menghitung total sisa tagihan yang belum dibayar (Total Awal - DP) khusus status belum lunas
            $pembayaranGantung = Pembayaran::where('id_pelanggan', $idPelanggan)
                ->whereColumn('bayar', '<', 'total_awal')
                ->get();
                
            $sisaTagihan = $pembayaranGantung->sum('total_awal') - $pembayaranGantung->sum('dp');

            return view('dashboard.index', compact('bookingAktif', 'totalKunjungan', 'sisaTagihan'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
