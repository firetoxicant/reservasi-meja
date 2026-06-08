@extends('layouts.index')
@section('title', 'Manajemen User')
@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Manajemen Pengguna (User)</h2>

    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <a href="{{ route('user.create') }}" class="px-4 py-2 text-sm font-medium leading-five text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700">
            Tambah
        </a>
        
        <form action="{{ route('user.index') }}" method="GET" class="w-full md:w-72">
            <div class="relative text-gray-500 focus-within:text-purple-600">
                <input name="search" value="{{ request('search') }}" class="w-full pl-8 pr-2 py-2 text-sm text-gray-700 bg-white border rounded-lg dark:bg-gray-800 dark:text-gray-300 focus:border-purple-400 focus:outline-none" placeholder="Cari nama atau username..." />
            </div>
        </form>
    </div>

    <div class="w-full overflow-hidden rounded-lg shadow-xs border dark:border-gray-700">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-white uppercase border-b bg-yellow-400 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-700">
                        <th class="px-4 py-3">Nama Lengkap</th>
                        <th class="px-4 py-3">Username</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse($users as $user)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3 text-sm font-medium">{{ $user->nama_lengkap }}</td>
                        <td class="px-4 py-3 text-sm">{{ $user->username }}</td>
                        <td class="px-4 py-3 text-sm">{{ $user->email }}</td>
                        <td class="px-4 py-3 text-xs">
                            @if($user->role === 'admin')
                                <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">Admin</span>
                            @elseif($user->role === 'kasir')
                                <span class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:bg-orange-700 dark:text-orange-100">Kasir</span>
                            @else
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Pelanggan</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm flex gap-2">
                            <a href="{{ route('user.edit', $user->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">Edit</a>
                            <span class="text-gray-300">|</span>
                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-sm text-center text-gray-500">Tidak ada data pengguna ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800 border-t dark:border-gray-700">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection