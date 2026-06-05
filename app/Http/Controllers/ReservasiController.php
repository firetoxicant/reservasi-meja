<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use App\Models\Menu;
use App\Models\Reservasi;
use App\Models\Order;
use App\Models\Pembayaran;
use App\Models\DBLogActivities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    // Step 1: Form Pencarian Meja Kosong
    public function index()
    {
        // Reset session booking lama jika user kembali ke awal
        session()->forget(['reservasi_meja_baru', 'keranjang']);

        $max_kapasitas = Meja::max('kapasitas_meja') ?? 10;
        return view('reservasi.index', compact('max_kapasitas'));
    }

    // Step 2: Menampilkan daftar Meja yang tersedia (Query Gacor bawaan Anda)
    public function mejaTersedia(Request $request)
    {
        $request->validate([
            'tanggal_reservasi' => 'required|date|after_or_equal:today',
            'jam_reservasi'     => 'required',
            'kapasitas'         => 'required|integer|min:1'
        ]);

        $tanggal = $request->tanggal_reservasi;
        $jam_mulai = $request->jam_reservasi;
        $jam_selesai = Carbon::createFromFormat('H:i', $jam_mulai)->addMinutes(90)->format('H:i');
        $kapasitas = $request->kapasitas;

        // Implementasi Query Anti-Double Booking dari file native Anda
        $meja_tersedia = Meja::where('kapasitas_meja', '>=', $kapasitas)
            ->where('status', 'tersedia')
            ->whereNotExists(function ($query) use ($tanggal, $jam_mulai, $jam_selesai) {
                $query->select(DB::raw(1))
                    ->from('reservasis')
                    ->whereColumn('reservasis.id_meja', 'mejas.id')
                    ->where('reservasis.tanggal_reservasi', $tanggal)
                    ->where('reservasis.jam_mulai', '<', $jam_selesai)
                    ->where('reservasis.jam_selesai', '>', $jam_mulai);
            })->get();

        return view('reservasi.meja_tersedia', compact('meja_tersedia', 'tanggal', 'jam_mulai', 'jam_selesai', 'kapasitas'));
    }

    // Menaruh data pilihan meja ke dalam Session sementara
    public function pilihMeja(Request $request)
    {
        session(['reservasi_meja_baru' => [
            'id_meja'     => $request->id_meja,
            'tanggal'     => $request->tanggal,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]]);

        return redirect()->route('reservasi.pilihMenu');
    }

    // Step 3: Memilih Hidangan Menu Makanan & Minuman
    public function pilihMenu()
    {
        if (!session()->has('reservasi_meja_baru')) {
            return redirect()->route('reservasi.index')->with('error', 'Silakan pilih jadwal dan meja terlebih dahulu.');
        }

        $menus = Menu::where('status', 'tersedia')->get();
        $total_item = session()->has('keranjang') ? array_sum(session('keranjang')) : 0;

        return view('reservasi.pilih_menu', compact('menus', 'total_item'));
    }

    // Memasukkan item makanan ke keranjang session
    public function tambahKeranjang(Request $request)
    {
        $id_menu = $request->id_menu;
        $porsi = $request->porsi;

        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id_menu])) {
            $keranjang[$id_menu] += $porsi;
        } else {
            $keranjang[$id_menu] = $porsi;
        }

        session(['keranjang' => $keranjang]);

        return redirect()->route('reservasi.pilihMenu')->with('success', 'Menu berhasil ditambahkan ke keranjang.');
    }

    // Halaman Review Item Keranjang Belanjaan
    public function keranjang()
    {
        $items = [];
        $total_bayar = 0;

        if (session()->has('keranjang')) {
            foreach (session('keranjang') as $id_menu => $porsi) {
                $menu = Menu::find($id_menu);
                if ($menu) {
                    $subtotal = $menu->harga * $porsi;
                    $total_bayar += $subtotal;
                    $items[] = [
                        'id_menu'   => $id_menu,
                        'nama_menu' => $menu->nama_menu,
                        'harga'     => $menu->harga,
                        'porsi'     => $porsi,
                        'subtotal'  => $subtotal
                    ];
                }
            }
        }

        return view('reservasi.keranjang', compact('items', 'total_bayar'));
    }

    // Menghapus item tertentu di keranjang
    public function hapusItemKeranjang($id)
    {
        $keranjang = session()->get('keranjang', []);
        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
            session(['keranjang' => $keranjang]);
        }
        return redirect()->route('reservasi.keranjang')->with('success', 'Item berhasil dihapus.');
    }

    // Step 4: Menampilkan Halaman Pembayaran DP 50%
    public function pembayaran()
    {
        if (!session()->has('reservasi_meja_baru')) {
            return redirect()->route('reservasi.index');
        }

        $total_akhir = 0;
        if (session()->has('keranjang')) {
            foreach (session('keranjang') as $id_menu => $porsi) {
                $menu = Menu::find($id_menu);
                if ($menu) {
                    $total_akhir += ($menu->harga * $porsi);
                }
            }
        }

        $dp_pembayaran = $total_akhir * 0.5; // DP Aturan 50%

        return view('reservasi.pembayaran', compact('total_akhir', 'dp_pembayaran'));
    }

    // FINAL STEP: Eksekusi Penyimpanan Terkunci (DB Transaction) ke 3 Tabel Sekaligus
    public function prosesPembayaran(Request $request)
    {
        $request->validate([
            'bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if (!session()->has('reservasi_meja_baru')) {
            return redirect()->route('reservasi.index');
        }

        $resSession = session('reservasi_meja_baru');
        $id_pelanggan = auth()->id();

        // Pembuatan Kode Reservasi Unik RESTO
        $kode_reservasi = "RSV-" . date('Ymd') . "-" . substr(time(), -4);

        DB::transaction(function () use ($request, $resSession, $id_pelanggan, $kode_reservasi) {
            // 1. Upload Berkas Bukti Transfer DP
            $filename = time() . '_' . $request->file('bukti')->getClientOriginalName();
            $request->file('bukti')->move(public_path('uploads/downpayment'), $filename);
            $pathBukti = 'uploads/downpayment/' . $filename;

            // 2. Simpan Data Induk ke `reservasis`
            $reservasi = Reservasi::create([
                'kode_reservasi'    => $kode_reservasi,
                'id_pelanggan'      => $id_pelanggan,
                'id_meja'           => $resSession['id_meja'],
                'jam_mulai'         => $resSession['jam_mulai'],
                'jam_selesai'       => $resSession['jam_selesai'],
                'tanggal_reservasi' => $resSession['tanggal'],
                'bukti'             => $pathBukti,
                'status_reservasi'  => 'belum lunas'
            ]);

            // 3. Simpan Data Finansial ke `pembayarans`
            Pembayaran::create([
                'id_reservasi' => $reservasi->id,
                'total_awal'   => $request->total_bayar,
                'dp'           => $request->dp,
                'bayar'        => 0,
                'kembali'      => 0,
                'id_pelanggan' => $id_pelanggan,
                'id_kasir'     => Auth()->user()->id,
            ]);

            // 4. Simpan Detail Pesanan Makanan ke `orders` & Potong Stok Menu
            if (session()->has('keranjang')) {
                foreach (session('keranjang') as $id_menu => $porsi) {
                    $menu = Menu::find($id_menu);
                    if ($menu) {
                        // Potong Stok
                        $menu->decrement('stok', $porsi);

                        // Simpan Detail Order
                        Order::create([
                            'id_reservasi' => $reservasi->id,
                            'id_menu'      => $id_menu,
                            'jumlah'       => $porsi,
                            'sub_total'    => $menu->harga * $porsi,
                        ]);
                    }
                }
            }

            // 5. Catat ke Sistem Log Aktivitas Baku Anda
            DB::table(DBLogActivities::TABLE_NAME)->insert([
                DBLogActivities::ACTION_COLUMN => DBLogActivities::CREATE,
                DBLogActivities::DESC_COLUMN   => 'Pelanggan melangsungkan Reservasi Baru dengan Kode: ' . $kode_reservasi,
                'created_at'                   => now(),
                'updated_at'                   => now()
            ]);
        });

        // Bersihkan data session agar tidak duplikat booking
        session()->forget(['keranjang', 'reservasi_meja_baru']);

        return redirect()->route('reservasi.index')->with('success', 'Selamat, Pemesanan Tempat Anda Telah Berhasil Diajukan!');
    }
}