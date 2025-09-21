<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pasien;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PendaftaranAkunPasienController extends Controller
{
    public function index()
    {
        return view('pendaftaran_akun_pasien');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nik'              => 'required|string|max:20|unique:pasien,nik',
            'nama_lengkap'     => 'required|string|max:255',
            'nama_panggilan'   => 'required|string|max:255',
            'jenis_kelamin'    => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'    => 'required|date',
            'no_hp'            => 'required|string|max:20',
            'alamat'           => 'required|string|max:255',
            'role'             => 'required|string|max:255',
            'username'         => 'required|string|max:255|unique:users,username',
            'email'            => 'required|string|email|max:255|unique:users,email',
            'password'         => 'required|string|min:6',
            'foto'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:512',
        ]);

        try {
            // Hash password
            $validatedData['password'] = bcrypt($validatedData['password']);

            // Simpan user dulu
            $user = User::create([
                'nama_lengkap' => $validatedData['nama_lengkap'],
                'nama_panggilan' => $validatedData['nama_panggilan'],
                'jenis_kelamin' => $validatedData['jenis_kelamin'],
                'tanggal_lahir' => $validatedData['tanggal_lahir'],
                'no_hp' => $validatedData['no_hp'],
                'alamat' => $validatedData['alamat'],
                'role' => $validatedData['role'],
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
            ]);

            // Jika ada foto, simpan ke storage
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $filename = Str::uuid() . '.' . $foto->getClientOriginalExtension();
                $foto->storeAs('foto', $filename, 'public');
                $user->foto = $filename;
                $user->save();
            }

            // Generate no_rm
            $lastPasien = Pasien::orderBy('id', 'desc')->first();
            $lastNumber = 0;
        
            if ($lastPasien && preg_match('/RM-(\d+)/', $lastPasien->no_rm, $matches)) {
                $lastNumber = (int) $matches[1];
            }
        
            $newNumber = $lastNumber + 1;
            $no_rm = 'RM-' . str_pad($newNumber, 2, '0', STR_PAD_LEFT);

            // Simpan pasien terkait
            Pasien::create([
                'user_id'        => $user->id,
                'no_rm'          => $no_rm,
                'nik'            => $validatedData['nik'],
                'nama_lengkap'   => $validatedData['nama_lengkap'],
                'nama_panggilan' => $validatedData['nama_panggilan'],
                'jenis_kelamin'  => $validatedData['jenis_kelamin'],
                'tanggal_lahir'  => $validatedData['tanggal_lahir'],
                'no_hp'          => $validatedData['no_hp'],
                'alamat'         => $validatedData['alamat'],
            ]);

            return redirect()->back()->with('success', 'Pendaftaran berhasil! Silakan login.');

        } catch (\Exception $e) {
            Log::error('Gagal menyimpan user atau pasien', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
        }
    }

}