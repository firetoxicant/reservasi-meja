@extends('layouts.index')
@section('title', 'Keranjang Pemesanan')
@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-yellow-400">Keranjang Hidangan Anda</h2>

    <div class="w-full overflow-hidden rounded-lg shadow-xs border">
        <table class="w-full">
            <thead>
                <tr class="text-xs font-semibold tracking-wide text-left text-gray-100 bg-yellow-400 uppercase">
                    <th class="px-4 py-3">Menu</th>
                    <th class="px-4 py-3">Harga</th>
                    <th class="px-4 py-3">Porsi</th>
                    <th class="px-4 py-3">Subtotal</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 dark:text-white divide-y">
                @forelse($items as $item)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $item['nama_menu'] }}</td>
                    <td class="px-4 py-3">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td class="px-4 py-3">{{ $item['porsi'] }} Porsi</td>
                    <td class="px-4 py-3 font-semibold text-green-600">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                    <td class="px-4 py-3">
                        <a href="{{ route('reservasi.hapusItem', $item['id_menu']) }}" class="text-red-600 hover:underline text-sm font-medium">Hapus</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">Keranjang masakan Anda kosong.</td>
                </tr>
                @endforelse
                <tr class="font-bold bg-gray-50 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                    <td colspan="3" class="px-4 py-3 text-right">Total Keseluruhan Tagihan:</td>
                    <td colspan="2" class="px-4 py-3 text-lg text-green-600">Rp {{ number_format($total_bayar, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('reservasi.pilihMenu') }}" class="px-4 py-2 border text-gray-700 bg-gray-400 rounded-md hover:bg-yellow-400 text-sm font-medium">
            Tambah Menu Lain
        </a>
        @if(count($items) > 0)
        <a href="{{ route('reservasi.pembayaran') }}" class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm font-medium shadow">
            Lanjut Pembayaran Uang Muka (DP) &rarr;
        </a>
        @endif
    </div>
</div>
@endsection