@extends('layouts.index')
@section('title', 'Meja')
@section('content')
<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-yellow-400">
        Data Meja
    </h2>

    <a href="{{ route('meja.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm text-center font-medium leading-5 w-32 ml-auto mb-4 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-lg hover:bg-green-700 focus:outline-none shadow">
        <i class="fas fa-plus-square mr-2"></i> Tambah
    </a>

    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-100 uppercase border-b dark:border-gray-700 bg-yellow-400 dark:text-white dark:bg-gray-800">
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Kapasitas</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse($mejas as $index => $row)
                    <tr class="dark:text-gray-200 hover:bg-yellow-100 dark:hover:text-gray-800">
                        <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2 font-medium">{{ $row->nama_meja }}</td>
                        <td class="border px-4 py-2">{{ $row->kapasitas_meja }} Orang</td>
                        <td class="border px-4 py-2">
                            @if($row->status == 'tersedia')
                            <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                {{ $row->status }}
                            </span>
                            @else
                            <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                                {{ $row->status }}
                            </span>
                            @endif
                        </td>
                        <td class="border px-4 py-2 flex items-center space-x-2">
                            <a href="{{ route('meja.edit', $row->id) }}">
                                <i class="fas fa-edit text-yellow-400 mr-2"></i>
                            </a>

                            <form action="{{ route('meja.destroy', $row->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus meja ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 focus:outline-none">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="border px-4 py-2 text-center text-gray-700 dark:text-gray-400">
                            Tidak ada data meja
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 bg-gray-50 border-t dark:bg-gray-800">
            {{ $mejas->links() }}
        </div>
    </div>
</div>
@endsection