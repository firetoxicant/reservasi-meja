@extends('layouts.index')
@section('title', 'Riwayat Transasi')
@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-yellow-400">
        Riwayat Transaksi
    </h2>

    <div class="w-full overflow-hidden rounded-lg shadow-xs border dark:border-gray-700">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-100 uppercase border-b dark:border-gray-700 bg-yellow-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Pelanggan / Kode</th>
                        <th class="px-4 py-3">Meja / Jadwal</th>
                        <th class="px-4 py-3">Total/Bukti DP</th>
                        <th class="px-4 py-3">Kasir</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Detail Pesanan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                    @forelse($riwayats as $row)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                        <td class="px-4 py-3 text-sm">
                            <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $row->user->nama_lengkap ?? 'User Terhapus' }}</p>
                            <p class="text-xs font-mono text-yellow-600 dark:text-yellow-400">{{ $row->kode_reservasi }}</p>
                        </td>

                        <td class="px-4 py-3 text-sm">
                            <p class="font-medium">{{ $row->meja->nama_meja ?? '-' }}</p>
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($row->tanggal_reservasi)->format('d/m/Y') }} | {{ substr($row->jam_mulai, 0, 5) }}
                            </p>
                        </td>

                        <td class="px-4 py-3">
                            <p class="text-sm font-semibold text-green-600 dark:text-green-400">Rp {{ number_format($row->pembayaran->total_awal ?? 0, 0, ',', '.') }}</p>
                            <a href="{{ asset($row->bukti) }}" target="_blank" class="text-blue-500 hover:underline flex items-center gap-1 text-xs font-medium">
                                <i class="fas fa-image"></i> Lihat Bukti
                            </a>
                        </td>

                        <td class="px-4 py-3 text-sm">
                            @if($row->pembayaran && $row->pembayaran->kasir)
                                <span class="px-2 py-1 text-xs font-bold text-blue-700 bg-blue-100 dark:bg-blue-700 dark:text-blue-100 rounded">
                                    {{ $row->pembayaran->kasir->nama_lengkap }}
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium text-gray-600 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 rounded">
                                    Pembayaran DP (Online)
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-sm">
                            <span class="px-4 py-2 text-xs font-semibold text-green-700 bg-green-100 dark:bg-green-700 dark:text-green-100 rounded-full">
                                Lunas
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <a href="{{ route('pesanan.detail', $row->id) }}" class="text-blue-500 hover:underline text-xs font-medium ms-2">
                                <i class="fas fa-eye"></i> Detail Menu
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">
                            <div class="text-3xl mb-2"><i class="fas fa-history"></i></div>
                            Tidak ditemukan data riwayat transaksi finansial yang lunas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 bg-gray-50 border-t dark:bg-gray-800">
            {{ $riwayats->links() }}
        </div>
    </div>
</div>
@endsection