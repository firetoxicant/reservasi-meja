<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // Fungsi untuk menampilkan halaman filter laporan di dashboard
    public function index(Request $request)
    {
        // Default tanggal: Awal bulan ini sampai hari ini jika admin belum memilih tanggal
        $tanggalAwal = $request->get('tanggal_awal', Carbon::now()->startOfMonth()->toDateString());
        $tanggalAkhir = $request->get('tanggal_akhir', Carbon::now()->toDateString());

        // Ambil data pembayaran berdasarkan rentang tanggal (di-filter dari kolom created_at)
        $laporanData = Pembayaran::with(['reservasi', 'pelanggan', 'kasir'])
            ->whereDate('created_at', '>=', $tanggalAwal)
            ->whereDate('created_at', '<=', $tanggalAkhir)
            ->latest()
            ->get();

        // Hitung akumulasi total uang untuk ringkasan di bawah tabel
        $grandTotalAwal = $laporanData->sum('total_awal');
        $grandTotalDp   = $laporanData->sum('dp');
        $grandTotalBayar = $laporanData->sum('bayar');

        return view('laporan.index', compact(
            'laporanData', 'tanggalAwal', 'tanggalAkhir', 
            'grandTotalAwal', 'grandTotalDp', 'grandTotalBayar'
        ));
    }

    // Fungsi untuk meng-export data hasil filter menjadi file PDF
    public function exportPdf(Request $request)
    {
        $tanggalAwal = $request->get('tanggal_awal');
        $tanggalAkhir = $request->get('tanggal_akhir');

        // Tarik data yang sama persis sesuai filter kurun waktu dari admin
        $laporanData = Pembayaran::with(['reservasi', 'pelanggan', 'kasir'])
            ->whereDate('created_at', '>=', $tanggalAwal)
            ->whereDate('created_at', '<=', $tanggalAkhir)
            ->orderBy('created_at', 'asc')
            ->get();

        $grandTotalAwal = $laporanData->sum('total_awal');
        $grandTotalDp   = $laporanData->sum('dp');
        $grandTotalBayar = $laporanData->sum('bayar');

        // Format tanggal untuk penamaan file download (Contoh: Laporan-2026-06-01-sd-2026-06-08.pdf)
        $fileName = 'Laporan-' . $tanggalAwal . '-sd-' . $tanggalAkhir . '.pdf';

        // Load view khusus template PDF dan lempar datanya
        $pdf = Pdf::loadView('laporan.pdf', compact(
            'laporanData', 'tanggalAwal', 'tanggalAkhir',
            'grandTotalAwal', 'grandTotalDp', 'grandTotalBayar'
        ))->setPaper('a4', 'landscape'); // Menggunakan orientasi Lanskap agar tabel muat banyak kolom

        return $pdf->download($fileName);
    }
}