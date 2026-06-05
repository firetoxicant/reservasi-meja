<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Http\Controllers\Controller;
use App\Models\DBLogActivities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::latest()->paginate(10);
        return view('menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:255|unique:menus,nama_menu',
            'harga'     => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'stok'      => 'required|integer|min:0',
            'kategori'  => 'required|in:makanan,minuman',
            'gambar'    => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'status'    => 'required|in:tersedia,habis',
        ], [
            'nama_menu.required' => 'Nama menu wajib diisi.',
            'nama_menu.unique'   => 'Nama menu sudah terdaftar.',
            'harga.required'     => 'Harga wajib diisi.',
            'stok.required'      => 'Stok wajib diisi.',
            'kategori.required'  => 'Kategori wajib dipilih.',
            'gambar.required'    => 'Gambar menu wajib diunggah.',
            'gambar.max'         => 'Ukuran gambar maksimal 2 MB.',
            'status.required'    => 'Status menu wajib dipilih.',
        ]);

        DB::transaction(function() use ($request, $validated) {
            // Proses upload gambar menu
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/menu'), $filename);
                $validated['gambar'] = 'uploads/menu/' . $filename;
            }

            Menu::create($validated);

            DB::table(DBLogActivities::TABLE_NAME)->insert([
                DBLogActivities::ACTION_COLUMN => DBLogActivities::CREATE,
                DBLogActivities::DESC_COLUMN   => 'Tambah Menu: ' . $validated['nama_menu'] . ' (Harga: Rp ' . number_format($validated['harga'], 0, ',', '.') . ')',
                'created_at'                   => now(),
                'updated_at'                   => now()
            ]);
        });

        return redirect()
            ->route('menu.index')
            ->with('success', 'Data menu berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        return view('menu.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        return view('menu.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:255|unique:menus,nama_menu,' . $menu->id,
            'harga'     => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'stok'      => 'required|integer|min:0',
            'kategori'  => 'required|in:makanan,minuman',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status'    => 'required|in:tersedia,habis',
        ], [
            'nama_menu.required' => 'Nama menu wajib diisi.',
            'nama_menu.unique'   => 'Nama menu sudah digunakan oleh menu lain.',
            'harga.required'     => 'Harga wajib diisi.',
            'stok.required'      => 'Stok wajib diisi.',
        ]);

        DB::transaction(function() use ($request, $validated, $menu) {
            // Proses upload gambar jika ada gambar baru
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada berkasnya
                if ($menu->gambar && file_exists(public_path($menu->gambar))) {
                    @unlink(public_path($menu->gambar));
                }

                $file = $request->file('gambar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/menu'), $filename);
                $validated['gambar'] = 'uploads/menu/' . $filename;
            }

            $menu->update($validated);

            DB::table(DBLogActivities::TABLE_NAME)->insert([
                DBLogActivities::ACTION_COLUMN => DBLogActivities::UPDATE,
                DBLogActivities::DESC_COLUMN   => 'Update Menu ID ' . $menu->id . ': Mengubah rincian menjadi ' . $validated['nama_menu'] . ' (Stok: ' . $validated['stok'] . ', Status: ' . $validated['status'] . ')',
                'created_at'                   => now(),
                'updated_at'                   => now()
            ]);
        });

        return redirect()
            ->route('menu.index')
            ->with('success', 'Data menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        DB::transaction(function() use ($menu) {
            $namaMenuTerhapus = $menu->nama_menu;

            // Hapus berkas gambar dari berkas lokal terlebih dahulu
            if ($menu->gambar && file_exists(public_path($menu->gambar))) {
                @unlink(public_path($menu->gambar));
            }
            
            $menu->delete();

            DB::table(DBLogActivities::TABLE_NAME)->insert([
                DBLogActivities::ACTION_COLUMN => DBLogActivities::DELETE,
                DBLogActivities::DESC_COLUMN   => 'Hapus Menu: Berhasil menghapus menu ' . $namaMenuTerhapus . ' dari sistem.',
                'created_at'                   => now(),
                'updated_at'                   => now()
            ]);
        });

        return redirect()
            ->route('menu.index')
            ->with('success', 'Data menu berhasil dihapus.');
    }
}