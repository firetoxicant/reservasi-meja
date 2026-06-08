@extends('layouts.index')
@section('title', 'Laporan Transaksi Restoran')
@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Laporan Transaksi Restoran</h2>

    <div class="p-4 mb-6 bg-white rounded-lg shadow-sm border dark:bg-gray-800 dark:border-gray-700">
        <form action="{{ route('laporan.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
            <div class="w-full md:w-1/3">
                <span class="text-gray-700 dark:text-gray-400 font-medium text-sm">Tanggal Mulai</span>
                <input type="date" name="tanggal_awal" value="{{ $tanggalAwal }}" required
                    class="block w-full mt-1 text-sm border rounded-lg p-2 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:border-blue-400" />
            </div>
            <div class="w-full md:w-1/3">
                <span class="text-gray-700 dark:text-gray-400 font-medium text-sm">Tanggal Batas Akhir</span>
                <input type="date" name="tanggal_akhir" value="{{ $tanggalAkhir }}" required
                    class="block w-full mt-1 text-sm border rounded-lg p-2 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:border-blue-400" />
            </div>
            <div class="w-full md:w-1/3 flex gap-2">
                <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                    Filter Data
                </button>
                <a href="{{ route('laporan.export', ['tanggal_awal' => $tanggalAwal, 'tanggal_akhir' => $tanggalAkhir]) }}" 
                   class="w-full text-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                   Export PDF
                </a>
            </div>
        </form>
    </div>

    <div class="w-full overflow-hidden rounded-lg shadow-xs border dark:border-gray-700">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-700">
                        <th class="px-4 py-3">Tanggal Transaksi</th>
                        <th class="px-4 py-3">Kode Booking</th>
                        <th class="px-4 py-3">Nama Pelanggan</th>
                        <th class="px-4 py-3">Kasir/Sistem</th>
                        <th class="px-4 py-3">Total Menu</th>
                        <th class="px-4 py-3">Uang Muka (DP)</th>
                        <th class="px-4 py-3">Jumlah Bayar</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse($laporanData as $data)
                    <tr class="text-gray-700 dark:text-gray-400 text-sm">
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y H:i') }}</td>
                        <td class="px-4 py-3 font-bold text-blue-600">{{ $data->reservasi->kode_reservasi ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $data->pelanggan->nama_lengkap ?? '-' }}</td>
                        <td class="px-4 py-3">
                            {{ $data->id_kasir === $data->id_pelanggan ? 'Self-Service' : ($data->kasir->nama_lengkap ?? '-') }}
                        </td>
                        <td class="px-4 py-3">Rp {{ number_format($data->total_awal, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-orange-500">Rp {{ number_format($data->dp, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 font-semibold text-green-600">Rp {{ number_format($data->bayar, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-3 text-center text-gray-500">Tidak ada transaksi pada kurun waktu terpilih.</td>
                    </tr>
                    @endforelse
                    
                    @if($laporanData->isNotEmpty())
                    <tr class="bg-gray-100 dark:bg-gray-700 font-bold text-gray-800 dark:text-gray-200">
                        <td colspan="4" class="px-4 py-3 text-right uppercase">Total Akumulasi Periode:</td>
                        <td class="px-4 py-3">Rp {{ number_format($grandTotalAwal, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-orange-600">Rp {{ number_format($grandTotalDp, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-green-600">Rp {{ number_format($grandTotalBayar, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection