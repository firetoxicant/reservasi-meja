@extends('layouts.index')
@section('title', 'Dashboard')
@section('content')
<div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-yellow-400">
        Dashboard
    </h2>
    @if(auth()->user()->role === 'admin')
    <div class="flex mb-8 items-center p-4 bg-white rounded-lg shadow-xs border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </div>
        <div>
            <p class="mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">
                Reservasi Hari Ini
            </p>
            <p class="text-xl font-semibold text-gray-700 dark:text-gray-200">
                {{ $reservasiHariIni }} <span class="text-xs font-normal text-gray-400 dark:text-gray-500">Kunjungan</span>
            </p>
        </div>
    </div>

    <div class="flex mb-8 items-center p-4 bg-white rounded-lg shadow-xs border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
        <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <p class="mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">
                Omzet Hari Ini
            </p>
            <p class="text-xl font-semibold text-green-600 dark:text-green-400">
                Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <div class="grid gap-6 mb-8 md:grid-cols-2">
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs border dark:bg-gray-800 dark:border-gray-700">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                Top 5 Menu Terlaris (Porsi)
            </h4>
            <div class="relative h-64 w-full flex justify-center">
                <canvas id="canvasPieMenu"></canvas>
            </div>
        </div>
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs border dark:bg-gray-800 dark:border-gray-700">
            <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">Analisis Jam Sibuk Kunjungan</h4>
            <div class="relative h-64 w-full">
                <canvas id="canvasDonutJamSibuk"></canvas>
            </div>
        </div>
    </div>

    <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs border dark:bg-gray-800 dark:border-gray-700">
        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
            Pendapatan Bulanan Tahun Ini (Rp)
        </h4>
        
        <div class="relative h-64 w-full">
            <canvas id="chartPendapatan"></canvas>
        </div>
    </div>
</div>;
@elseif(auth()->user()->role === 'kasir')
<div class="grid gap-6 mb-8 md:grid-cols-3">
    
    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <div>
            <p class="mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">
                Reservasi (Hari Ini)
            </p>
            <p class="text-xl font-semibold text-gray-700 dark:text-gray-200">
                {{ $totalReservasiDatangHariIni }} <span class="text-xs font-normal text-gray-400">Total Kunjungan</span>
            </p>
        </div>
    </div>

    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
        <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
            </svg>
        </div>
        <div>
            <p class="mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">
                Reservasi Anda Tangani
            </p>
            <p class="text-xl font-semibold text-gray-700 dark:text-gray-200">
                {{ $reservasiDitanganiKasir }} <span class="text-xs font-normal text-gray-400 dark:text-gray-500">Transaksi Selesai</span>
            </p>
        </div>
    </div>

    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
        <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <div>
            <p class="mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">
                Total Setoran Uang Anda
            </p>
            <p class="text-xl font-semibold text-green-600 dark:text-green-400">
                Rp {{ number_format($uangMasukKasir, 0, ',', '.') }}
            </p>
        </div>
    </div>
@else
    <div class="grid gap-6 mb-8 md:grid-cols-3">
        
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full dark:text-purple-100 dark:bg-purple-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">Booking Aktif</p>
                <p class="text-xl font-semibold text-gray-700 dark:text-gray-200">{{ $bookingAktif }} <span class="text-xs font-normal text-gray-400">Jadwal</span></p>
            </div>
        </div>

        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">Total Kunjungan Anda</p>
                <p class="text-xl font-semibold text-gray-700 dark:text-gray-200">{{ $totalKunjungan }} <span class="text-xs font-normal text-gray-400">Kali Datang</span></p>
            </div>
        </div>

        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <p class="mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">Sisa Tagihan (Pelunasan)</p>
                <p class="text-xl font-semibold text-red-600 dark:text-red-400">Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
@endif
@if(auth()->user()->role === 'admin')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ambil elemen canvas
        const ctx = document.getElementById('chartPendapatan').getContext('2d');
        const ctxPie = document.getElementById('canvasPieMenu').getContext('2d');
        const ctxDonut = document.getElementById('canvasDonutJamSibuk').getContext('2d');
        
        // Mengonversi data array PHP dari Controller ke Array JavaScript
        const labelBulan = @json($labels);
        const dataNominal = @json($dataPendapatan);
        const namaMenu = @json($labelsMenu);
        const totalPorsi = @json($dataPorsi);
        const namaJam = @json($labelsJam);
        const totalReservasi = @json($dataJumlahReservasi);

        // Konfigurasi Chart.js
        new Chart(ctx, {
            type: 'bar', // Anda bisa ganti jadi 'line', 'pie', atau 'doughnut'
            data: {
                labels: labelBulan,
                datasets: [{
                    label: 'Total Pendapatan (Rp)',
                    data: dataNominal,
                    backgroundColor: 'rgba(234, 179, 8, 0.6)', // Warna Kuning Tema Proyek Anda (dengan opacity)
                    borderColor: 'rgba(234, 179, 8, 1)',      // Warna Border Kuning Solid
                    borderWidth: 2,
                    borderRadius: 5 // Membuat sudut bar agak melengkung miring rapi
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // Format angka ribuan agar rapi dibaca kasir/admin
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            },
                            color: '#9ca3af' // Warna teks abu-abu agar pas dengan Dark Mode
                        },
                        grid: {
                            color: 'rgba(156, 163, 175, 0.1)' // Garis grid transparan
                        }
                    },
                    x: {
                        ticks: {
                            color: '#9ca3af'
                        },
                        grid: {
                            display: false // Hilangkan garis vertikal agar lebih bersih
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#9ca3af'
                        }
                    }
                }
            }
        });

        new Chart(ctxDonut, {
            type: 'doughnut', // Menggunakan tipe DOUGHNUT chart
            data: {
                labels: namaJam,
                datasets: [{
                    label: 'Jumlah Reservasi',
                    data: totalReservasi,
                    // Variasi warna cerah untuk setiap potongan kue (slice) pie chart
                    backgroundColor: [
                        'rgba(234, 179, 8, 0.7)',  // Kuning (Warna tema utama)
                        'rgba(34, 197, 94, 0.7)',  // Hijau
                        'rgba(59, 130, 246, 0.7)',  // Biru
                        'rgba(239, 68, 68, 0.7)',   // Merah
                        'rgba(168, 85, 247, 0.7)'   // Ungu
                    ],
                    borderColor: [
                        'rgba(234, 179, 8, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(59, 130, 246, 1)',
                        'rgba(239, 68, 68, 1)',
                        'rgba(168, 85, 247, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right', // Posisi keterangan label menu ditaruh di sebelah kanan grafik
                        labels: {
                            color: '#9ca3af', // Menyesuaikan warna teks agar kompatibel dengan Dark Mode
                            font: { size: 12 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            // Format teks pop-up saat kursor diarahkan ke bagian grafik
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                return ' ' + label + ': ' + value + ' Porsi';
                            }
                        }
                    }
                }
            }
        });
        new Chart(ctxPie, {
            type: 'pie', // Menggunakan tipe PIE chart
            data: {
                labels: namaMenu,
                datasets: [{
                    label: 'Porsi Terjual',
                    data: totalPorsi,
                    // Variasi warna cerah untuk setiap potongan kue (slice) pie chart
                    backgroundColor: [
                        'rgba(234, 179, 8, 0.7)',  // Kuning (Warna tema utama)
                        'rgba(34, 197, 94, 0.7)',  // Hijau
                        'rgba(59, 130, 246, 0.7)',  // Biru
                        'rgba(239, 68, 68, 0.7)',   // Merah
                        'rgba(168, 85, 247, 0.7)'   // Ungu
                    ],
                    borderColor: [
                        'rgba(234, 179, 8, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(59, 130, 246, 1)',
                        'rgba(239, 68, 68, 1)',
                        'rgba(168, 85, 247, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right', // Posisi keterangan label menu ditaruh di sebelah kanan grafik
                        labels: {
                            color: '#9ca3af', // Menyesuaikan warna teks agar kompatibel dengan Dark Mode
                            font: { size: 12 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            // Format teks pop-up saat kursor diarahkan ke bagian grafik
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                return ' ' + label + ': ' + value + ' Porsi';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endif
@endsection