@extends('layouts.index')
@section('title', 'Kelola Reservasi')
@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-yellow-400">
        Daftar Seluruh Reservasi
    </h2>

    <div class="w-full overflow-hidden rounded-lg shadow-xs border dark:border-gray-700">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-100 uppercase border-b dark:border-gray-700 bg-yellow-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Pelanggan / Kode</th>
                        <th class="px-4 py-3">Meja / Waktu</th>
                        <th class="px-4 py-3">Pembayaran (DP)</th>
                        <th class="px-4 py-3">Bukti</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse($reservasis as $row)
                    @php
                        // Menghitung sisa tagihan pelunasan
                        $total = $row->pembayaran->total_awal ?? 0;
                        $dp = $row->pembayaran->dp ?? 0;
                        $sisa = $total - $dp;
                        
                        // Menentukan apakah sudah lunas dari rekaman data 'bayar' di DB
                        // Jika kolom 'bayar' sudah sama atau lebih besar dari total tagihan, maka lunas
                        $isLunas = ($row->pembayaran->bayar ?? 0) >= $total && $total > 0;
                    @endphp
                    <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-900">
                        <!-- Pelanggan & Kode -->
                        <td class="px-4 py-3 text-sm border-b dark:border-gray-700">
                            <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $row->user->nama_lengkap ?? 'Pelanggan Terhapus' }}</p>
                            <p class="text-xs font-mono text-yellow-600 dark:text-yellow-400">{{ $row->kode_reservasi }}</p>
                        </td>
                        
                        <!-- Meja & Waktu Kunjungan -->
                        <td class="px-4 py-3 text-sm border-b dark:border-gray-700">
                            <p class="font-medium">{{ $row->meja->nama_meja ?? 'Meja -' }}</p>
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($row->tanggal_reservasi)->format('d/m/y') }} | {{ substr($row->jam_mulai, 0, 5) }}
                            </p>
                        </td>
                        
                        <!-- Pembayaran Finansial -->
                        <td class="px-4 py-3 text-sm border-b dark:border-gray-700">
                            <p class="text-gray-600 dark:text-gray-400">Total: <span class="font-semibold text-gray-800 dark:text-white">Rp {{ number_format($total, 0, ',', '.') }}</span></p>
                            <p class="text-xs text-green-600 font-bold">DP: Rp {{ number_format($dp, 0, ',', '.') }}</p>
                        </td>
                        
                        <!-- Bukti Transfer Berkas -->
                        <td class="px-4 py-3 text-sm border-b dark:border-gray-700">
                            @if($row->bukti)
                                <a href="{{ asset($row->bukti) }}" target="_blank" class="text-blue-500 hover:underline flex items-center gap-1 text-xs font-medium">
                                    <i class="fas fa-image"></i> Lihat Bukti
                                </a>
                            @else
                                <span class="text-xs italic text-gray-400">Tanpa Bukti</span>
                            @endif
                        </td>
                        
                        <!-- Aksi Dinamis Kasir -->
                        <td class="px-4 py-3 text-sm border-b dark:border-gray-700">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('pesanan.detail', $row->id) }}" 
                                   class="px-3 py-1 text-xs font-medium text-white bg-yellow-400 hover:bg-yellow-500 rounded transition shadow-sm">
                                    Cek Order
                                </a>
                                
                                @if(auth()->user()->role === 'kasir')
                                    <a href="{{ route('pesanan.pelunasan', $row->id) }}" 
                                       class="px-3 py-1 text-xs font-medium text-white bg-blue-500 hover:bg-blue-600 rounded transition shadow-sm">
                                        Pelunasan (Sisa: Rp {{ number_format($sisa, 0, ',', '.') }})
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                            Belum ada riwayat reservasi pelanggan yang masuk ke dalam sistem.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Links Laravel -->
        <div class="px-4 py-3 bg-gray-50 border-t dark:bg-gray-800">
            {{ $reservasis->links() }}
        </div>
    </div>
</div>
@endsection