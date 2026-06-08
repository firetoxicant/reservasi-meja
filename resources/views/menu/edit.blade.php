@extends('layouts.index')
@section('title', 'Edit Menu')
@section('content')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-yellow-400">
            Edit Rincian Menu
        </h2>

        <div class="px-6 py-4 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')
                
                @include('menu.form')

                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('menu.index') }}" 
                       class="border border-gray-300 bg-gray-300 text-gray-700 dark:text-dark hover:bg-yellow-400 font-medium px-6 py-2 rounded-md transition text-sm">
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