@extends('layouts.index')
@section('title', 'Detail Order')
@section('content')
<div class="container px-6 mx-auto grid">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center my-6 gap-2">
        <div>
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-yellow-400">
                Detail Menu Dipesan
            </h2>
            <p class="text-sm text-gray-500 font-mono mt-1">Kode: {{ $reservasi->kode_reservasi }}</p>
        </div>
        <a href="#" onclick="window.history.back()" class="px-4 py-2 text-sm bg-gray-500 hover:bg-yellow-400 text-white rounded-lg shadow font-medium transition">
            &larr; Kembali ke Daftar
        </a>
    </div>

    <div class="grid gap-4 mb-6 md:grid-cols-3 text-sm">
        <div class="p-4 bg-white rounded-lg shadow border dark:bg-gray-800 dark:border-gray-700">
            <span class="text-xs font-bold text-yellow-400 uppercase">Nama Pelanggan</span>
            <p class="font-semibold text-gray-800 dark:text-gray-200 mt-1">{{ $reservasi->user->nama_lengkap ?? 'Pelanggan Terhapus' }}</p>
        </div>
        <div class="p-4 bg-white rounded-lg shadow border dark:bg-gray-800 dark:border-gray-700">
            <span class="text-xs font-bold text-yellow-400 uppercase">Meja Dipilih</span>
            <p class="font-semibold text-gray-800 dark:text-gray-200 mt-1">{{ $reservasi->meja->nama_meja ?? '-' }}</p>
        </div>
        <div class="p-4 bg-white rounded-lg shadow border dark:bg-gray-800 dark:border-gray-700">
            <span class="text-xs font-bold text-yellow-400 uppercase">Jadwal Kunjungan</span>
            <p class="font-semibold text-gray-800 dark:text-gray-200 mt-1">
                {{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi)->format('d M Y') }} ({{ substr($reservasi->jam_mulai, 0, 5) }} WIB)
            </p>
        </div>
    </div>

    <div class="w-full overflow-hidden rounded-lg shadow border dark:border-gray-700">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-100 uppercase bg-yellow-400 dark:bg-gray-800 border-b dark:border-gray-700">
                        <th class="px-4 py-3">Nama Hidangan</th>
                        <th class="px-4 py-3 text-center">Harga Satuan</th>
                        <th class="px-4 py-3 text-center">Kuantitas</th>
                        <th class="px-4 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                    @php $totalMurni = 0; @endphp
                    @forelse($reservasi->orders as $order)
                    @php $totalMurni += $order->sub_total; @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                        <td class="px-4 py-3 font-medium capitalize">
                            {{ $order->menu->nama_menu ?? 'Menu Telah Dihapus Resto' }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            Rp {{ number_format($order->menu->harga ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center font-bold">
                            {{ $order->jumlah }} Porsi
                        </td>
                        <td class="px-4 py-3 text-right font-semibold text-green-600 dark:text-green-400">
                            Rp {{ number_format($order->sub_total, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500 italic">
                            Pelanggan hanya memesan tempat duduk (tidak memesan hidangan makanan/minuman terlebih dahulu).
                        </td>
                    </tr>
                    @endforelse
                    
                    <tr class="font-extrabold bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white">
                        <td colspan="3" class="px-4 py-3 text-right">Total :</td>
                        <td class="px-4 py-3 text-right text-lg text-green-600 dark:text-green-400">
                            Rp {{ number_format($totalMurni, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection