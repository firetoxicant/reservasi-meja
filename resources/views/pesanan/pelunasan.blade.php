@extends('layouts.index')
@section('title', 'Pelunasan Reservasi')
@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-yellow-400">
        Form Transaksi Pelunasan Sisa Tagihan
    </h2>

    <div class="grid gap-6 mb-8 md:grid-cols-2">
        <div class="p-5 bg-white rounded-lg shadow border dark:bg-gray-800 dark:border-gray-700 border-l-4 border-blue-500 flex flex-col justify-between">
            <div>
                <h4 class="mb-4 font-bold text-gray-700 dark:text-gray-200 border-b pb-2">Informasi Nota Billing #{{ $reservasi->kode_reservasi }}</h4>
                <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                    <p class="flex justify-between"><span>Nama Pelanggan:</span> <strong class="text-gray-800 dark:text-white">{{ $reservasi->user->nama_lengkap ?? '-' }}</strong></p>
                    <p class="flex justify-between"><span>Total Biaya Awal:</span> <span class="font-semibold">Rp {{ number_format($pembayaran->total_awal, 0, ',', '.') }}</span></p>
                    <p class="flex justify-between text-green-600 dark:text-green-400"><span>Uang Deposit (DP 50%) Masuk:</span> <span class="font-bold">- Rp {{ number_format($pembayaran->dp, 0, ',', '.') }}</span></p>
                </div>
            </div>
            
            <div class="mt-6 pt-4 border-t dark:border-gray-700">
                <span class="text-xs text-gray-400 block uppercase font-bold tracking-wider">Kekurangan Yang Harus Dilunasi:</span>
                <span class="text-3xl font-black text-red-600 dark:text-red-400 mt-1 block">
                    Rp {{ number_format($sisa_tagihan, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <div class="p-5 bg-white rounded-lg shadow border dark:bg-gray-800 dark:border-gray-700">
            <h4 class="mb-4 font-bold text-gray-700 dark:text-gray-200">Eksekusi Pembayaran Tunai/Debit</h4>
            
            @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-xs font-semibold">
                {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('pesanan.prosesPelunasan', $reservasi->id) }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-1">
                        Jumlah Uang Diterima dari Pelanggan (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="jumlah_bayar" name="jumlah_bayar" required min="{{ $sisa_tagihan }}" placeholder="Contoh: 150000"
                           class="w-full px-3 py-2.5 text-lg font-bold border rounded-md focus:outline-none focus:ring focus:ring-blue-300 dark:bg-gray-700 dark:text-white">
                    <p class="text-xs text-gray-400 mt-1">Masukkan nominal angka murni tanpa titik atau koma.</p>
                </div>

                <div class="p-3 bg-gray-50 dark:bg-gray-900 rounded-lg text-sm text-gray-600 dark:text-gray-300">
                    <p class="flex justify-between font-medium">
                        <span>Uang Kembalian Pelanggan:</span>
                        <span id="label_kembalian" class="font-extrabold text-gray-800 dark:text-white">Rp 0</span>
                    </p>
                </div>

                <div class="flex gap-2 pt-2">
                    <a href="{{ route('pesanan.index') }}" class="w-1/3 text-center p-2 text-sm font-medium border text-gray-700 rounded-md hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700 transition">
                        Batal
                    </a>
                    <button type="submit" class="w-2/3 p-2 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-md shadow transition">
                        <i class="fas fa-check-circle mr-1"></i> Simpan & Lunaskan Nota
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputBayar = document.getElementById('jumlah_bayar');
        const labelKembalian = document.getElementById('label_kembalian');
        const sisaTagihan = {{ $sisa_tagihan }};

        inputBayar.addEventListener('input', function() {
            const nilaiBayar = parseFloat(this.value) || 0;
            const hitungKembalian = nilaiBayar - sisaTagihan;

            if (hitungKembalian >= 0) {
                // Format mata uang rupiah indonesia
                labelKembalian.innerText = "Rp " + hitungKembalian.toLocaleString('id-ID');
                labelKembalian.classList.remove('text-red-500');
                labelKembalian.classList.add('text-green-600', 'dark:text-green-400');
            } else {
                labelKembalian.innerText = "Uang Pembayaran Belum Cukup";
                labelKembalian.classList.remove('text-green-600', 'dark:text-green-400');
                labelKembalian.classList.add('text-red-500');
            }
        });
    });
</script>
@endsection