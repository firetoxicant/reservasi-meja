<div class="grid gap-6 md:grid-cols-2">
    <label class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400 font-medium">Nama Lengkap</span>
        <input name="nama_lengkap" type="text" required 
            value="{{ old('nama_lengkap', $user->nama_lengkap ?? '') }}"
            class="block w-full mt-1 text-sm border rounded-lg p-2 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:border-blue-400" />
        @error('nama_lengkap') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
    </label>

    <label class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400 font-medium">Username</span>
        <input name="username" type="text" required 
            value="{{ old('username', $user->username ?? '') }}"
            class="block w-full mt-1 text-sm border rounded-lg p-2 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:border-blue-400" />
        @error('username') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
    </label>

    <label class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400 font-medium">Email</span>
        <input name="email" type="email" required 
            value="{{ old('email', $user->email ?? '') }}"
            class="block w-full mt-1 text-sm border rounded-lg p-2 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:border-blue-400" />
        @error('email') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
    </label>

    <label class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400 font-medium">
            Password 
            @if(isset($user)) 
                <span class="text-xs text-gray-400 font-normal">*(Kosongkan jika tidak diubah)</span> 
            @endif
        </span>
        <input name="password" type="password" {{ isset($user) ? '' : 'required' }}
            class="block w-full mt-1 text-sm border rounded-lg p-2 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:border-blue-400" />
        @error('password') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
    </label>

    <label class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400 font-medium">Hak Akses (Role)</span>
        <select name="role" required class="block w-full mt-1 text-sm border rounded-lg p-2 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:border-blue-400">
            @php $currentRole = old('role', $user->role ?? ''); @endphp
            <option value="pelanggan" {{ $currentRole == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
            <option value="kasir" {{ $currentRole == 'kasir' ? 'selected' : '' }}>Kasir</option>
            <option value="admin" {{ $currentRole == 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
        @error('role') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
    </label>
</div>

<div class="flex justify-end gap-3 mt-6">
    <a href="{{ route('user.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
        Batal
    </a>
    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
        {{ isset($user) ? 'Perbarui Pengguna' : 'Simpan Pengguna' }}
    </button>
</div>