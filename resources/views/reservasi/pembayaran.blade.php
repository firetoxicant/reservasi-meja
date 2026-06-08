@extends('layouts.index')
@section('title', 'Unggah Bukti DP')
@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-yellow-400">Pembayaran Down Payment (DP) 50%</h2>

    <div class="grid gap-6 mb-8 md:grid-cols-2">
        <div class="p-5 bg-white dark:bg-gray-800 rounded-lg shadow-md border-l-4 border-yellow-400">
            <h4 class="mb-2 font-semibold text-gray-700 dark:text-white">Rekening Transfer Bank</h4>
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">Silakan transfer kewajiban deposit sebesar:</p>
            <p class="text-3xl font-extrabold text-green-600 mb-4">Rp {{ number_format($dp_pembayaran, 0, ',', '.') }}</p>
            <div class="p-3 bg-gray-50 dark:bg-gray-600 rounded text-sm text-gray-700 dark:text-gray-300 space-y-1">
                <p><strong>Bank BCA:</strong> 123-456-7890</p>
                <p><strong>Atas Nama:</strong> Resto Ayam Bolo Bebek</p>
            </div>
        </div>

        <div class="p-5 bg-white dark:bg-gray-800 rounded-lg shadow-md border-l-4 border-green-400">
            <form action="{{ route('reservasi.prosesPembayaran') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" name="total_bayar" value="{{ $total_akhir }}">
                <input type="hidden" name="dp" value="{{ $dp_pembayaran }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Unggah Bukti Transfer Berhasil</label>
                    <input type="file" name="bukti" required accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100 border p-2 rounded-lg">
                    <p class="text-xs text-gray-400 mt-1">Maksimal resolusi berkas gambar 2 MB</p>
                </div>

                <button type="submit" class="w-full mt-4 px-4 py-3 text-sm font-semibold text-white bg-green-600 hover:bg-green-700 rounded-lg shadow transition">
                    Kirim Konfirmasi Reservasi Saya
                </button>
            </form>
        </div>
    </div>
</div>
@endsection