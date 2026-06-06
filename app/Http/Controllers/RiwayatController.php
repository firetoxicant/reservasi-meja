<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    /**
     * Menampilkan riwayat transaksi yang sudah lunas.
     */
    public function index()
    {
        $user = auth()->user();
        $role = $user->role;

        // Base Query: Mengambil reservasi yang sudah LUNAS beserta relasinya
        // Eager Loading mencegah N+1 Query Problem
        $query = Reservasi::with(['user', 'meja', 'pembayaran.kasir'])
            ->whereHas('pembayaran', function ($q) {
                // Kondisi lunas: nilai 'bayar' sudah mencukupi atau menyamai 'total_awal'
                $q->whereColumn('bayar', '>=', 'total_awal');
            });

        // Pengkondisian Khusus berdasarkan Role Akun
        if ($role === 'pelanggan') {
            // Pelanggan hanya bisa melihat riwayat miliknya sendiri
            $query->where('id_pelanggan', $user->id);
        } elseif ($role === 'kasir') {
            // Kasir hanya melihat riwayat transaksi yang dieksekusi oleh dirinya sendiri
            $query->whereHas('pembayaran', function ($q) use ($user) {
                $q->where('id_kasir', $user->id);
            });
        }

        $riwayats = $query->orderBy('id', 'desc')->paginate(10);

        return view('riwayat.index', compact('riwayats', 'role'));
    }
}