<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;

class PesananSayaController extends Controller
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
