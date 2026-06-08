{{-- Tampilkan error validasi --}}
@if ($errors->any())
<div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm">
    <p class="font-semibold text-red-700 mb-2">Terdapat kesalahan penginputan:</p>
    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="space-y-4">
    {{-- Nama Meja & Kapasitas Meja --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-white mb-1">
                Nama / Nomor Meja <span class="text-red-500">*</span>
            </label>
            <input type="text" name="nama_meja" 
                   value="{{ old('nama_meja', $meja->nama_meja ?? '') }}" 
                   required maxlength="20" placeholder="Contoh: Meja 01"
                   class="w-full px-3 py-2 border border-gray-300 dark:bg-gray-700 dark:text-white rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-white mb-1">
                Kapasitas Meja (Orang) <span class="text-red-500">*</span>
            </label>
            <input type="number" name="kapasitas_meja" 
                   value="{{ old('kapasitas_meja', $meja->kapasitas_meja ?? '1') }}" 
                   required min="1"
                   class="w-full px-3 py-2 border border-gray-300 dark:bg-gray-700 dark:text-white rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
        </div>
    </div>

    {{-- Status Ketersediaan Meja --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-white mb-1">
            Status Ketersediaan <span class="text-red-500">*</span>
        </label>
        <select name="status" required 
                class="w-full px-3 py-2 border border-gray-300 dark:bg-gray-700 dark:text-white rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
            <option value="" disabled {{ !isset($meja) ? 'selected' : '' }}>-- Pilih Status Ketersediaan --</option>
            <option value="tersedia" {{ old('status', $meja->status ?? '') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
            <option value="tidak tersedia" {{ old('status', $meja->status ?? '') == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
        </select>
    </div>

    {{-- Input Berkas Foto Meja --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-white mb-1">
            Foto Kondisi Meja <span class="text-gray-400 text-xs">(Opsional)</span>
        </label>
        @if(isset($meja) && $meja->foto)
        <div class="mb-3">
            <img src="{{ asset($meja->foto) }}" alt="Preview Meja" class="w-32 h-24 rounded-md object-cover border">
            <p class="text-xs text-gray-500 mt-1">Foto saat ini</p>
        </div>
        @endif
        <input type="file" name="foto" accept="image/jpeg,image/png,image/jpg"
               class="w-full px-3 py-2 border border-gray-300 dark:bg-gray-700 dark:text-white rounded-md bg-white focus:outline-none">
        <p class="text-xs text-gray-500 mt-1">Format: JPG/JPEG/PNG · Maksimal 2 MB</p>
    </div>
</div>