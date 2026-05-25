<div
        x-show="isSideMenuOpen"
        x-transition:enter="transition ease-in-out duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in-out duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
      ></div>
      <aside
        class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
        x-show="isSideMenuOpen"
        x-transition:enter="transition ease-in-out duration-150"
        x-transition:enter-start="opacity-0 transform -translate-x-20"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in-out duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0 transform -translate-x-20"
        @click.away="closeSideMenu"
        @keydown.escape="closeSideMenu"
      >
        <div class="py-4 text-gray-500 dark:text-gray-400">
          <a
            class="ml-6 text-lg font-bold text-yellow-300 dark:text-yellow-300"
            href="#"
          >
            AYAM BOLO BEBEK
          </a>
          <ul class="mt-6">
            <li class="relative px-6 py-3">
              <!-- Active items have the snippet below -->
              <span
                        class="absolute inset-y-0 left-0 w-1 bg-yellow-400 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"
                      ></span>
              <!-- Add this classes to an active anchor (a tag) -->
              <!-- text-gray-800 dark:text-gray-100 -->
              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                href="../dashboard/dashboard.php">
                <i class="fas fa-home"></i>
                <span class="ml-4">Dashboard</span>
              </a>
            </li>
            <hr>
            <li class="relative px-6 py-3">
              <!-- Active items have the snippet below -->
              <span
                        class="absolute inset-y-0 left-0 w-1 bg-yellow-400 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"
                      ></span>
              <!-- Add this classes to an active anchor (a tag) -->
              <!-- text-gray-800 dark:text-gray-100 -->
              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                href="../meja/meja.php">
                <i class="fas fa-th-large"></i>
                <span class="ml-4">Data Meja</span>
              </a>
            </li>
            <li class="relative px-6 py-3">
              <!-- Active items have the snippet below -->
              <span
                        class="absolute inset-y-0 left-0 w-1 bg-yellow-400 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"
                      ></span>
              <!-- Add this classes to an active anchor (a tag) -->
              <!-- text-gray-800 dark:text-gray-100 -->
              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                href="../menu/menu.php">
                <i class="fas fa-utensils"></i>
                <span class="ml-4">Data Menu</span>
              </a>
            </li>
              <li class="relative px-6 py-3">
                <!-- Active items have the snippet below -->
                <span
                        class="absolute inset-y-0 left-0 w-1 bg-yellow-400 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"
                      ></span>
              <!-- Add this classes to an active anchor (a tag) -->
              <!-- text-gray-800 dark:text-gray-100 -->
              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              href="../pesanan/pesanan.php">
              <i class="fas fa-shopping-cart"></i>
              <span class="ml-4">Pesanan</span>
            </a>
            </li> 
            <hr>
            <li class="relative px-6 py-3">
              <!-- Active items have the snippet below -->
              <span
                        class="absolute inset-y-0 left-0 w-1 bg-yellow-400 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"
                      ></span>
              <!-- Add this classes to an active anchor (a tag) -->
              <!-- text-gray-800 dark:text-gray-100 -->
              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                href="../reservasi/reservasi.php">
                <i class="fas fa-edit"></i>
                <span class="ml-4">Reservasi</span>
              </a>
            </li>
            <li class="relative px-6 py-3">
              <!-- Active items have the snippet below -->
              <span
                        class="absolute inset-y-0 left-0 w-1 bg-yellow-400 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"
                      ></span>
              <!-- Add this classes to an active anchor (a tag) -->
              <!-- text-gray-800 dark:text-gray-100 -->
              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                href="../reservasi/reservasiSaya.php">
                <i class="fas fa-ticket-alt"></i>
                <span class="ml-4">Reservasi Saya</span>
              </a>
            </li>
            <hr>
            <li class="relative px-6 py-3">
              <!-- Active items have the snippet below -->
              <span
                        class="absolute inset-y-0 left-0 w-1 bg-yellow-400 rounded-tr-lg rounded-br-lg"
                        aria-hidden="true"
                      ></span>
              <!-- Add this classes to an active anchor (a tag) -->
              <!-- text-gray-800 dark:text-gray-100 -->
              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                href="../riwayat/riwayat.php">
                <i class="fas fa-history"></i>
                <span class="ml-4">Riwayat</span>
              </a>
            </li>
          </ul>
        </div>
      </aside>