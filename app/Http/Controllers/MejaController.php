<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Http\Controllers\Controller;
use App\Models\DBLogActivities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MejaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mejas = Meja::latest()->paginate(10);
        return view('meja.index', compact('mejas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('meja.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_meja'      => 'required|string|max:20|unique:mejas,nama_meja',
            'kapasitas_meja' => 'required|integer|min:1',
            'status'         => 'required|in:tersedia,tidak tersedia',
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi foto
        ], [
            'nama_meja.required'      => 'Nama meja wajib diisi.',
            'nama_meja.unique'        => 'Nama meja sudah terdaftar.',
            'kapasitas_meja.required' => 'Kapasitas meja wajib diisi.',
            'status.required'         => 'Status meja wajib dipilih.',
            'foto.image'              => 'Berkas harus berupa gambar.',
            'foto.max'                => 'Ukuran foto maksimal 2 MB.',
        ]);

        DB::transaction(function() use ($request, $validated) {
            // Proses upload foto meja jika ada
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/meja'), $filename);
                $validated['foto'] = 'uploads/meja/' . $filename;
            }

            Meja::create($validated);

            DB::table(DBLogActivities::TABLE_NAME)->insert([
                DBLogActivities::ACTION_COLUMN => DBLogActivities::CREATE,
                DBLogActivities::DESC_COLUMN   => 'Tambah Meja: ' . $validated['nama_meja'] . ' (Kapasitas: ' . $validated['kapasitas_meja'] . ' Orang)',
                'created_at'                   => now(),
                'updated_at'                   => now()
            ]);
        });

        return redirect()
            ->route('meja.index')
            ->with('success', 'Data meja berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meja $meja)
    {
        return view('meja.edit', compact('meja'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meja $meja)
    {
        $validated = $request->validate([
            'nama_meja'      => 'required|string|max:20|unique:mejas,nama_meja,' . $meja->id,
            'kapasitas_meja' => 'required|integer|min:1',
            'status'         => 'required|in:tersedia,tidak tersedia',
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi foto
        ], [
            'nama_meja.required' => 'Nama meja wajib diisi.',
            'nama_meja.unique'   => 'Nama meja sudah digunakan oleh meja lain.',
            'foto.image'         => 'Berkas harus berupa gambar.',
        ]);

        DB::transaction(function() use ($request, $validated, $meja) {
            // Proses upload foto jika ada berkas baru yang diunggah
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada berkas fisik di folder
                if ($meja->foto && file_exists(public_path($meja->foto))) {
                    @unlink(public_path($meja->foto));
                }

                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/meja'), $filename);
                $validated['foto'] = 'uploads/meja/' . $filename;
            }

            $meja->update($validated);

            DB::table(DBLogActivities::TABLE_NAME)->insert([
                DBLogActivities::ACTION_COLUMN => DBLogActivities::UPDATE,
                DBLogActivities::DESC_COLUMN   => 'Update Meja ID ' . $meja->id . ': Mengubah data menjadi ' . $validated['nama_meja'] . ' (Kapasitas: ' . $validated['kapasitas_meja'] . ' Orang, Status: ' . $validated['status'] . ')',
                'created_at'                   => now(),
                'updated_at'                   => now()
            ]);
        });

        return redirect()
            ->route('meja.index')
            ->with('success', 'Data meja berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meja $meja)
    {
        DB::transaction(function() use ($meja) {
            $namaMejaTerhapus = $meja->nama_meja;
            
            // Hapus foto dari penyimpanan lokal jika ada sebelum record di-delete
            if ($meja->foto && file_exists(public_path($meja->foto))) {
                @unlink(public_path($meja->foto));
            }

            $meja->delete();

            DB::table(DBLogActivities::TABLE_NAME)->insert([
                DBLogActivities::ACTION_COLUMN => DBLogActivities::DELETE,
                DBLogActivities::DESC_COLUMN   => 'Hapus Meja: Berhasil menghapus data ' . $namaMejaTerhapus . ' dari sistem.',
                'created_at'                   => now(),
                'updated_at'                   => now()
            ]);
        });

        return redirect()
            ->route('meja.index')
            ->with('success', 'Data meja berhasil dihapus.');
    }
}