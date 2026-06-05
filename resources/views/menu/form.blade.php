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
    {{-- Nama Menu & Kategori --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Nama Menu <span class="text-red-500">*</span>
            </label>
            <input type="text" name="nama_menu" 
                   value="{{ old('nama_menu', $menu->nama_menu ?? '') }}" 
                   required maxlength="255" placeholder="Contoh: Ayam Bolo Bakar"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Kategori <span class="text-red-500">*</span>
            </label>
            <select name="kategori" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
                <option value="" disabled {{ !isset($menu) ? 'selected' : '' }}>-- Pilih Kategori --</option>
                <option value="makanan" {{ old('kategori', $menu->kategori ?? '') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                <option value="minuman" {{ old('kategori', $menu->kategori ?? '') == 'minuman' ? 'selected' : '' }}>Minuman</option>
            </select>
        </div>
    </div>

    {{-- Harga & Stok --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Harga (Rp) <span class="text-red-500">*</span>
            </label>
            <input type="number" name="harga" 
                   value="{{ old('harga', $menu->harga ?? '') }}" 
                   required min="0" placeholder="Contoh: 25000"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Stok Awal <span class="text-red-500">*</span>
            </label>
            <input type="number" name="stok" 
                   value="{{ old('stok', $menu->stok ?? '0') }}" 
                   required min="0"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
        </div>
    </div>

    {{-- Deskripsi Menu --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Menu</label>
        <textarea name="deskripsi" rows="3" placeholder="Tuliskan racikan bumbu pendek atau deskripsi menu..."
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">{{ old('deskripsi', $menu->deskripsi ?? '') }}</textarea>
    </div>

    {{-- Status Menu --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Status Ketersediaan <span class="text-red-500">*</span>
        </label>
        <select name="status" required 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:outline-none">
            <option value="tersedia" {{ old('status', $menu->status ?? 'tersedia') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
            <option value="habis" {{ old('status', $menu->status ?? '') == 'habis' ? 'selected' : '' }}>Habis / Kosong</option>
        </select>
    </div>

    {{-- File Gambar Menu --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Gambar Menu @if(!isset($menu)) <span class="text-red-500">*</span> @endif
        </label>
        @if(isset($menu) && $menu->gambar)
        <div class="mb-3">
            <img src="{{ asset($menu->gambar) }}" alt="Preview" class="w-32 h-32 rounded-md object-cover border">
            <p class="text-xs text-gray-500 mt-1">Gambar saat ini</p>
        </div>
        @endif
        <input type="file" name="gambar" accept="image/jpeg,image/png,image/jpg" @if(!isset($menu)) required @endif
               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-white focus:outline-none">
        <p class="text-xs text-gray-500 mt-1">Format: JPG/JPEG/PNG · Maksimal 2 MB</p>
    </div>
</div>