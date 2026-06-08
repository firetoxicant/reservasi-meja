@extends('layouts.index')
@section('title', 'Meja yang Tersedia')
@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-yellow-400">
        Meja Tersedia (Jadwal: {{ $jam_mulai }} - {{ $jam_selesai }})
    </h2>

    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4 w-full">
        @forelse($meja_tersedia as $meja)
        <div class="flex flex-col bg-white dark:bg-gray-800 rounded-lg shadow-md border overflow-hidden">
            @if($meja->foto)
                <img src="{{ asset($meja->foto) }}" class="h-48 w-full object-cover">
            @else
                <div class="h-48 bg-gray-200 flex items-center justify-center text-gray-400">Tidak ada foto</div>
            @endif
            <div class="p-4 flex flex-col flex-grow">
                <h4 class="font-semibold text-lg text-gray-800 dark:text-white">{{ $meja->nama_meja }}</h4>
                <p class="text-sm text-gray-600 mb-4">Maksimal: {{ $meja->kapasitas_meja }} Orang</p>
                
                <form action="{{ route('reservasi.pilihMeja') }}" method="POST" class="mt-auto">
                    @csrf
                    <input type="hidden" value="{{ $meja->id }}" name="id_meja">
                    <input type="hidden" value="{{ $tanggal }}" name="tanggal">
                    <input type="hidden" value="{{ $jam_mulai }}" name="jam_mulai">
                    <input type="hidden" value="{{ $jam_selesai }}" name="jam_selesai">
                    <button type="submit" class="w-full text-center py-2 text-sm font-medium text-white bg-yellow-400 hover:bg-yellow-500 rounded-md transition shadow">
                        Pilih Meja Ini
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 text-center text-gray-500">
            Maaf, tidak ada meja kosong yang mencukupi untuk waktu tersebut.
        </div>
        @endforelse
    </div>
</div>
@endsection