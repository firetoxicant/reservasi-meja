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
    
    public function postlogin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
        ]);

        $remember = $request->has('remember_me');
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $response = redirect('/');
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

        return back()->withErrors([
            'email' => 'Email tidak ditemukan.',
        ]);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect('/login');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
