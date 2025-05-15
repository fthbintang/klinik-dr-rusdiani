<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login.
     *
     * @return \Illuminate\View\View Halaman login untuk pengguna.
     */
    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => ['required'], // Username wajib diisi
            'password' => ['required'], // Password wajib diisi
        ], [
            'username.required' => 'Username wajib diisi!',
            'password.required' => 'Password wajib diisi!',
        ]);

        // Coba otentikasi pengguna dengan kredensial yang diberikan
        if (Auth::attempt($credentials)) {
            // Regenerasi session untuk keamanan
            $request->session()->regenerate();

            // Redirect ke halaman dashboard jika login berhasil
            return redirect()->intended('dashboard');
        }

        // Jika otentikasi gagal, kembali ke halaman login dengan pesan error
        return redirect('/')->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }
}