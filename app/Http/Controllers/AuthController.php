<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
    */
    public function index()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }
    
    public function postlogin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
        ]);

        $remember = $request->has('remember_me');
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $response = redirect('/dashboard')->with('success', 'Selamat datang ' . Auth::user()->nama_lengkap . '. Kamu login sebagai ' . Auth::user()->role . '.');
            if($remember){
                $response->withCookie(cookie()->make('remember_email', $request->email, 60 * 24 * 7))
                        ->withCookie(cookie()->make('remember_password', $request->password, 60 * 24 * 7));// Menyimpan cookie selama 30 hari
            }else {
                $response->withCookie(cookie()->forget('remember_email'))
                        ->withCookie(cookie()->forget('remember_password'));
            }

        }else{
            return back()->with('error', 'Email atau password salah.');
        }
        return $response;
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Logout berhasil.');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): RedirectResponse
    {
        // 1. Jalankan Validasi (Jika gagal, otomatis return kembalikan pesan error ke view)
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:30',
            'email'        => 'required|string|email|max:50|unique:users,email',
            'username'     => 'required|string|max:15|unique:users,username', // Disarankan unik
            'password'     => 'required|string|min:6',
            'role'         => 'nullable|in:admin,kasir,pelanggan',
        ]);

        try {
            // 2. Set Nilai Default untuk Role jika kosong atau tidak diinputkan
            $validatedData['role'] = $request->filled('role') ? $request->role : 'pelanggan';

            // 3. Enkripsi Password
            $validatedData['password'] = Hash::make($request->password);

            // 4. Daftarkan User ke Database
            User::create($validatedData);

            return redirect('/login')->with('success', 'Akun berhasil dibuat! Silakan login.');

        } catch (\Exception $e) {
            // Jika terjadi error tidak terduga pada database (misal database mati/putus koneksi)
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
