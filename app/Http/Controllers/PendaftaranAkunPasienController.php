<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PendaftaranAkunPasienController extends Controller
{
    public function index()
    {
        return view('pendaftaran_akun_pasien');
    }

    public function store(Request $request)
    {
        // return $request;
        $validatedData = $request->validate([
            'nama_lengkap'     => 'required|string|max:255',
            'nama_panggilan'   => 'required|string|max:255',
            'jenis_kelamin'    => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'    => 'nullable|date',
            'no_hp'            => 'nullable|string|max:20',
            'alamat'           => 'nullable|string|max:255',
            'role'             => 'required|string|max:255',
            'username'         => 'required|string|max:255|unique:users,username',
            'password'         => 'required|string|min:6',
            'foto'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:512',
        ]);

        try {
            // Hash password
            $validatedData['password'] = bcrypt($validatedData['password']);

            // Create user without foto first
            $user = User::create($validatedData);

            // Jika ada file foto, simpan ke storage dan update nama file ke DB
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $filename = Str::uuid() . '.' . $foto->getClientOriginalExtension();
                $foto->storeAs('foto', $filename, 'public');
                $user->foto = $filename;
                $user->save();
            }

            // Redirect ke route index dengan pesan sukses
            return redirect()->back()->with('success', 'Pendaftaran berhasil! Silakan login.');

        } catch (\Exception $e) {
            Log::error('Gagal menyimpan user baru', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
        }
    }
}