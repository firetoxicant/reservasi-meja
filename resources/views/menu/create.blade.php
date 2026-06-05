@extends('layouts.index')
@section('title', 'Tambah Menu')
@section('content')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-yellow-400">
            Tambah Menu Hidangan Baru
        </h2>

        <div class="px-6 py-4 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            {{-- Ditambahkan enctype="multipart/form-data" untuk penanganan unggah berkas --}}
            <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                
                @include('menu.form')

                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('menu.index') }}" 
                       class="border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium px-6 py-2 rounded-md transition text-sm">
                        Kembali
                    </a>
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-2 rounded-md transition text-sm shadow">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection