@extends('layouts.index')
@section('title', 'Pilih Menu Resto')
@section('content')
<div class="container px-6 mx-auto grid">
    <div class="flex justify-between items-center my-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-yellow-400">Pilih Menu Hidangan</h2>
        <a href="{{ route('reservasi.keranjang') }}" class="px-4 py-2 bg-yellow-400 text-white rounded-lg font-medium shadow text-sm transition hover:bg-yellow-500">
            <i class="fas fa-shopping-cart mr-1"></i> Lihat Keranjang ({{ $total_item }})
        </a>
    </div>

    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
        @foreach($menus as $menu)
        <div class="flex flex-col bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md border">
            @if($menu->gambar)
                <img src="{{ asset($menu->gambar) }}" class="h-40 w-full object-cover rounded-md mb-2">
            @endif
            <h3 class="font-bold text-gray-800 dark:text-white text-lg capitalize">{{ $menu->nama_menu }}</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2 line-clamp-2">{{ $menu->deskripsi }}</p>
            <p class="text-green-600 font-bold text-md mt-auto mb-3">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>

            <form action="{{ route('reservasi.tambahKeranjang') }}" method="POST" class="grid grid-cols-2 gap-2">
                @csrf
                <input type="hidden" name="id_menu" value="{{ $menu->id }}">
                <input type="number" name="porsi" min="1" value="1" max="{{ $menu->stok }}" required
                       class="px-2 py-1.5 border dark:bg-gray-700 dark:text-white placeholder:text-gray-500 focus:outline-none">
                <button type="submit" class="text-sm font-medium text-white bg-green-500 hover:bg-green-600 rounded-md py-2 shadow">
                    + Tambah
                </button>
            </form>
        </div>
        @endforeach
    </div>
</div>
@endsection