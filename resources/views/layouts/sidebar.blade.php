<aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
    <div class="py-4 text-gray-500 dark:text-gray-100">
        <a class="ml-6 text-lg font-bold text-yellow-300 dark:text-yellow-400" href="/ayambolobebek/pages">
            AYAM BOLO BEBEK
        </a>
        <ul class="mt-6">
            <li class="relative px-6 py-3">
                <!-- Active items have the snippet below -->
                 @if(request()->is('dashboard*'))
                <span class="absolute inset-y-0 left-0 w-1 bg-yellow-400 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                    @endif
                <!-- Add this classes to an active anchor (a tag) -->
                <!-- text-gray-800 dark:text-gray-100 -->
                <a class="@if(request()->is('dashboard*'))
                text-gray-800 dark:text-yellow-300
                @endif
                inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('dashboard.index') }}">
                    <i class="fas fa-home"></i>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>
            <hr>
            @if(auth()->user()->role == 'admin')
            <li class="relative px-6 py-3">
                <!-- Active items have the snippet below -->
                @if(request()->is('meja*'))
                <span class="absolute inset-y-0 left-0 w-1 bg-yellow-400 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                @endif
                <!-- Add this classes to an active anchor (a tag) -->
                <!-- text-gray-800 dark:text-gray-100 -->
                <a class="@if(request()->is('meja*'))
                text-gray-800 dark:text-yellow-300
                @endif
                inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('meja.index') }}">
                    <i class="fas fa-th-large"></i>
                    <span class="ml-4">Data Meja</span>
                </a>
            </li>
            <li class="relative px-6 py-3">
                <!-- Active items have the snippet below -->
                @if(request()->is('menu*'))
                <span class="absolute inset-y-0 left-0 w-1 bg-yellow-400 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                @endif
                <!-- Add this classes to an active anchor (a tag) -->
                <!-- text-gray-800 dark:text-gray-100 -->
                <a class="@if(request()->is('menu*'))
                text-gray-800 dark:text-yellow-300
                @endif
                inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('menu.index') }}">
                    <i class="fas fa-utensils"></i>
                    <span class="ml-4">Data Menu</span>
                </a>
            </li>
            <li class="relative px-6 py-3">
                <!-- Active items have the snippet below -->
                @if(request()->is('user*'))
                <span class="absolute inset-y-0 left-0 w-1 bg-yellow-400 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                @endif
                <!-- Add this classes to an active anchor (a tag) -->
                <!-- text-gray-800 dark:text-gray-100 -->
                <a class="@if(request()->is('user*'))
                text-gray-800 dark:text-yellow-300
                @endif
                inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('user.index') }}">
                    <i class="fas fa-users"></i>
                    <span class="ml-4">Data User</span>
                </a>
            </li>
            @endif
            <hr>
            @if(auth()->user()->role == 'kasir' || auth()->user()->role == 'admin')
            <li class="relative px-6 py-3">
                <!-- Active items have the snippet below -->
                @if(request()->is('pesanan*'))
                <span class="absolute inset-y-0 left-0 w-1 bg-yellow-400 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                @endif
                <!-- Add this classes to an active anchor (a tag) -->
                <!-- text-gray-800 dark:text-gray-100 -->
                <a class="@if(request()->is('pesanan*'))
                text-gray-800 dark:text-yellow-300
                @endif
                inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('pesanan.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="ml-4">Pesanan</span>
                </a>
            </li>
            @endif
            <hr>
            @if(auth()->user()->role == 'pelanggan')
            <li class="relative px-6 py-3">
                <!-- Active items have the snippet below -->
                @if(request()->is('reservasi*'))
                <span class="absolute inset-y-0 left-0 w-1 bg-yellow-400 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                @endif
                <!-- Add this classes to an active anchor (a tag) -->
                <!-- text-gray-800 dark:text-gray-100 -->
                <a class="@if(request()->is('reservasi*'))
                text-gray-800 dark:text-yellow-300
                @endif
                inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('reservasi.index') }}">
                    <i class="fas fa-edit"></i>
                    <span class="ml-4">Reservasi</span>
                </a>
            </li>
            <li class="relative px-6 py-3">
                <!-- Active items have the snippet below -->
                @if(request()->is('saya'))
                <span class="absolute inset-y-0 left-0 w-1 bg-yellow-400 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                @endif
                <!-- Add this classes to an active anchor (a tag) -->
                <!-- text-gray-800 dark:text-gray-100 -->
                <a class="@if(request()->is('saya'))
                text-gray-800 dark:text-yellow-300
                @endif
                inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('saya') }}">
                    <i class="fas fa-ticket-alt"></i>
                    <span class="ml-4">Reservasi Saya</span>
                </a>
            </li>
            <hr>
            @endif
            <li class="relative px-6 py-3">
                <!-- Active items have the snippet below -->
                @if(request()->is('riwayat*'))
                <span class="absolute inset-y-0 left-0 w-1 bg-yellow-400 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                @endif
                <!-- Add this classes to an active anchor (a tag) -->
                <!-- text-gray-800 dark:text-gray-100 -->
                <a class="@if(request()->is('riwayat*'))
                text-gray-800 dark:text-yellow-300
                @endif
                inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('riwayat.index') }}">
                    <i class="fas fa-history"></i>
                    <span class="ml-4">Riwayat</span>
                </a>
            </li>
            @if(auth()->user()->role == 'admin')
            <li class="relative px-6 py-3">
                <!-- Active items have the snippet below -->
                @if(request()->is('laporan*'))
                <span class="absolute inset-y-0 left-0 w-1 bg-yellow-400 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                @endif
                <!-- Add this classes to an active anchor (a tag) -->
                <!-- text-gray-800 dark:text-gray-100 -->
                <a class="@if(request()->is('laporan*'))
                text-gray-800 dark:text-yellow-300
                @endif
                inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('laporan.index') }}">
                    <i class="fas fa-file"></i>
                    <span class="ml-4">Laporan</span>
                </a>
            </li>
            @endif
        </ul>
        <!-- <div class="px-6 my-6">
            <button
              class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
            >
              Create account
              <span class="ml-2" aria-hidden="true">+</span>
            </button>
          </div> -->
    </div>
</aside>
