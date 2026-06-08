<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use App\Models\DBLogActivities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    /**
     * Menampilkan daftar seluruh reservasi untuk kebutuhan kasir.
     */
    public function index()
    {
        // Proteksi manual: Jika bkn admin atau kasir, lempar ke halaman home/error
       if (!in_array(auth()->user()->role, ['kasir', 'admin'])) {
           abort(403, 'Anda tidak memiliki hak akses ke halaman kasir.');
       }
        // Mengambil data reservasi terbaru beserta relasi user, meja, dan pembayarannya
        $reservasis = Reservasi::with(['user', 'meja', 'pembayaran'])
            ->whereIn('status_reservasi', ['belum lunas'])
            ->orderBy('tanggal_reservasi', 'asc')
            ->paginate(10);

        return view('pesanan.index', compact('reservasis'));
    }

    /**
     * Memproses transaksi pelunasan sisa tagihan oleh Kasir (Contoh Aksi Eksekusi)
     */
    public function prosesPelunasan(Request $request, $id)
    {
        $reservasi = Reservasi::with('pembayaran')->findOrFail($id);
        $pembayaran = $reservasi->pembayaran;

        // Hitung sisa tagihan yang harus dibayar
        $sisa_tagihan = $pembayaran->total_awal - $pembayaran->dp;

        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:' . $sisa_tagihan,
        ], [
            'jumlah_bayar.min' => 'Uang pembayaran kurang untuk melunasi sisa tagihan.',
        ]);

        DB::transaction(function () use ($request, $reservasi, $pembayaran, $sisa_tagihan) {
            $uang_masuk = $request->jumlah_bayar;
            $kembalian = $uang_masuk - $sisa_tagihan;

            // Update status finansial di tabel pembayaran
            // Kolom 'bayar' kini diisi total penuh (DP + Sisa Pelunasan)
            $pembayaran->update([
                'bayar'   => $pembayaran->total_awal, 
                'kembali' => $kembalian,
                'id_kasir' => auth()->id()
            ]);

            // Ubah status reservasi menjadi terkonfirmasi penuh/selesai
            $reservasi->update([
                'status_reservasi' => 'lunas'
            ]);

            // Log aktivitas kasir
            DB::table(DBLogActivities::TABLE_NAME)->insert([
                DBLogActivities::ACTION_COLUMN => DBLogActivities::UPDATE,
                DBLogActivities::DESC_COLUMN   => 'Kasir menerima pelunasan pesanan ' . $reservasi->kode_reservasi . '. Kembalian: Rp ' . number_format($kembalian),
                'created_at'                   => now(),
                'updated_at'                   => now()
            ]);
        });

        return redirect()
            ->route('pesanan.index')
            ->with('success', 'Reservasi ' . $reservasi->kode_reservasi . ' dinyatakan LUNAS.');
    }

    /**
     * Menampilkan detail hidangan menu yang dipesan di dalam suatu reservasi.
     */
    public function detail($id)
    {
        // Mengambil data reservasi beserta detail menu yang dipesan (orders.menu)
        $reservasi = Reservasi::with(['user', 'meja', 'orders.menu'])->findOrFail($id);

        return view('pesanan.detail', compact('reservasi'));
    }

    /**
     * Menampilkan formulir input pembayaran untuk pelunasan sisa tagihan.
     */
    public function pelunasanForm($id)
    {
        $reservasi = Reservasi::with(['user', 'pembayaran'])->findOrFail($id);
        $pembayaran = $reservasi->pembayaran;

        // Hitung sisa tagihan (Total Awal - DP)
        $sisa_tagihan = $pembayaran->total_awal - $pembayaran->dp;

        // Jika ternyata sudah lunas, kembalikan ke halaman utama dengan pesan peringatan
        if (($pembayaran->bayar ?? 0) >= $pembayaran->total_awal) {
            return redirect()->route('pesanan.index')->with('error', 'Reservasi ini sudah lunas.');
        }

        return view('pesanan.pelunasan', compact('reservasi', 'pembayaran', 'sisa_tagihan'));
    }
}