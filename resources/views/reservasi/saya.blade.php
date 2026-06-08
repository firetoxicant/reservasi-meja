@extends('layouts.index')
@section('title', 'Reservasi Saya')
@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-yellow-400">
        Reservasi Saya
    </h2>

    <div class="grid gap-6 mb-8 md:grid-cols-2">
        @forelse($reservasis as $res)
        <div class="p-4 bg-white rounded-lg shadow-md dark:bg-gray-800 border flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-center border-b pb-2 mb-4">
                    <div>
                        <span class="text-xs font-bold text-gray-400 block">KODE RESERVASI</span>
                        <span class="font-mono font-bold text-lg text-yellow-400 dark:text-yellow-400">
                            {{ $res->kode_reservasi }}
                        </span>
                    </div>
                    <div>
                        @if($res->status_reservasi == 'pending')
                            <span class="px-3 py-1 text-xs font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full">
                                Pending
                            </span>
                        @elseif($res->status_reservasi == 'confirmed')
                            <span class="px-3 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                Dikonfirmasi
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                {{ ucfirst($res->status_reservasi) }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 dark:text-gray-300 mb-4 bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                    <p><strong>Nama Meja:</strong> <br><span class="text-gray-800 dark:text-white font-medium">{{ $res->meja->nama_meja ?? '-' }}</span></p>
                    <p><strong>Kapasitas:</strong> <br><span class="text-gray-800 dark:text-white font-medium">{{ $res->meja->kapasitas_meja ?? 0 }} Orang</span></p>
                    <p class="mt-2"><strong>Tanggal:</strong> <br><span class="text-gray-800 dark:text-white font-medium">{{ \Carbon\Carbon::parse($res->tanggal_reservasi)->format('d M Y') }}</span></p>
                    <p class="mt-2"><strong>Waktu:</strong> <br><span class="text-gray-800 dark:text-white font-medium">{{ substr($res->jam_mulai, 0, 5) }} - {{ substr($res->jam_selesai, 0, 5) }}</span></p>
                </div>

                <div class="text-sm text-gray-600 dark:text-gray-300 mb-4 border-b pb-3">
                    <p class="flex justify-between mb-1">
                        <span>Total Tagihan:</span>
                        <span class="font-semibold text-gray-800 dark:text-white">
                            Rp {{ number_format($res->pembayaran->total_awal ?? 0, 0, ',', '.') }}
                        </span>
                    </p>
                    <p class="flex justify-between">
                        <span>DP yang Dibayar (50%):</span>
                        <span class="font-semibold text-green-600 dark:text-green-400">
                            Rp {{ number_format($res->pembayaran->dp ?? 0, 0, ',', '.') }}
                        </span>
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-xs font-bold text-gray-500 uppercase mb-2 tracking-wider">Menu yang Dipesan:</p>
                    <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1 bg-yellow-50 dark:bg-gray-900 dark:bg-opacity-20 p-3 rounded-lg border border-yellow-100 dark:border-gray-700">
                        @forelse($res->orders as $order)
                        <li class="flex justify-between items-center">
                            <span class="capitalize">{{ $order->menu->nama_menu ?? 'Menu Terhapus' }}</span>
                            <span class="font-semibold text-gray-800 dark:text-gray-200">x{{ $order->jumlah }}</span>
                        </li>
                        @empty
                        <li class="text-xs italic text-gray-400">Tidak ada pemesanan menu (Hanya Booking Meja)</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            @if($res->bukti)
            <div class="mt-2 pt-2 border-t dark:border-gray-700 flex items-center justify-between">
                <span class="text-xs text-gray-400">Bukti DP terunggah</span>
                <a href="{{ asset($res->bukti) }}" target="_blank" class="text-xs text-blue-500 hover:underline font-medium flex items-center gap-1">
                    <i class="fas fa-image"></i> Lihat Bukti Transfer
                </a>
            </div>
            @endif
        </div>
        @empty
        <div class="col-span-full text-center py-16 bg-white rounded-lg border dark:bg-gray-800">
            <div class="text-gray-400 mb-3 text-4xl">
                <i class="fas fa-calendar-times"></i>
            </div>
            <p class="text-gray-500 dark:text-gray-400 font-medium">Anda belum memiliki jadwal reservasi aktif saat ini.</p>
            <a href="{{ route('reservasi.index') }}" class="mt-4 inline-block px-5 py-2 text-sm bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg shadow font-semibold transition">
                Pesan Meja Sekarang
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection