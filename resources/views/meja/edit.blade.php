@extends('layouts.index')
@section('title', 'Edit Meja')
@section('content')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-yellow-400">
            Edit Rincian Meja
        </h2>

        <div class="px-6 py-4 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            {{-- Tambahkan enctype="multipart/form-data" --}}
            <form action="{{ route('meja.update', $meja->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')
                
                {{-- Memanggil Partial Form yang sama --}}
                @include('meja.form')

                {{-- Tombol Aksi Akhir Form --}}
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('meja.index') }}" 
                       class="border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium px-6 py-2 rounded-md transition text-sm">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-6 py-2 rounded-md transition text-sm shadow">
                        Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection