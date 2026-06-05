<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservasiSayaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id_user = auth()->id();
        $tanggal_sekarang = date('Y-m-d');

        // Mengambil data reservasi milik user login yang tanggalnya hari ini ke atas
        // Menggunakan Eager Loading untuk mengambil data relasi meja, pembayaran, dan detail order menu sekaligus
        $reservasis = Reservasi::with(['meja', 'pembayaran', 'orders.menu'])
            ->where('id_pelanggan', $id_user)
            ->where('tanggal_reservasi', '>=', $tanggal_sekarang)
            ->orderBy('id', 'desc')
            ->get();

        return view('reservasi.saya', compact('reservasis'));
    }
}
