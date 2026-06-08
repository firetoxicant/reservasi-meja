@extends('layouts.index')
@section('title', 'Tambah User Baru')
@section('content')
<div class="container px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Tambah User Baru</h2>

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 border dark:border-gray-700">
        <form action="{{ route('user.store') }}" method="POST">
            @csrf
            
            @include('user.form')
            
        </form>
    </div>
</div>
@endsection