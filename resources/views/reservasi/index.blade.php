@extends('layouts.index')
@section('title', 'Reservasi Tempat')
@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-yellow-400">Reservasi Meja Restoran</h2>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form action="{{ route('reservasi.mejaTersedia') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-white">Tanggal Reservasi</label>
                <input type="date" name="tanggal_reservasi" required min="{{ date('Y-m-day') }}"
                       class="w-full mt-1 px-3 py-2 border dark:bg-gray-700 dark:text-white placeholder:text-gray-500 focus:outline-none focus:ring focus:ring-yellow-300">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-white">Jam Mulai Datang</label>
                <select name="jam_reservasi" required class="w-full mt-1 px-3 py-2 border dark:bg-gray-700 dark:text-white rounded-md focus:outline-none">
                    <option value="" disabled selected>-- Pilih Jam --</option>
                    @for($h=10; $h<=21; $h++)
                        @foreach(['00','30'] as $m)
                            <option value="{{ sprintf('%02d:%s', $h, $m) }}">{{ sprintf('%02d:%s', $h, $m) }}</option>
                        @endforeach
                    @endfor
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-white">Kapasitas Tempat Duduk</label>
                <select name="kapasitas" required class="w-full mt-1 px-3 py-2 border dark:bg-gray-700 dark:text-white rounded-md focus:outline-none">
                    <option value="" disabled selected>Pilih Jumlah Orang...</option>
                    @for($i = 1; $i <= $max_kapasitas; $i++)
                        <option value="{{ $i }}">{{ $i }} Orang</option>
                    @endfor
                </select>
            </div>

            <button type="submit" class="w-full sm:w-auto px-6 py-3 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 shadow">
                <i class="fas fa-search mr-2"></i> Cari Meja Kosong
            </button>
        </form>
    </div>
</div>
@endsection