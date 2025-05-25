<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    public function index(User $user)
    {
        return view('profile.index', [
            'title' => 'Halaman Profile',
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'nama_lengkap'     => 'required|string|max:255',
            'nama_panggilan'   => 'required|string|max:255',
            'jenis_kelamin'    => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'    => 'nullable|date',
            'no_hp'            => 'nullable|string|max:20',
            'alamat'           => 'nullable|string|max:255',
            'role'             => 'required|string|max:255',
            'username'         => 'required|string|max:255',
            'password'         => 'nullable|string|min:6',
            'foto'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:512',
            ]);
        
        try {
            // Perbarui data pengguna dengan data yang dikirimkan melalui formulir
            $user->nama_lengkap = $validatedData['nama_lengkap'];
            $user->nama_panggilan = $validatedData['nama_panggilan'];
            $user->alamat = $validatedData['alamat'];
            $user->tanggal_lahir = $validatedData['tanggal_lahir'];
            $user->username = $validatedData['username'];

            // Perbarui password jika ada
            if ($validatedData['password']) {
                $user->password = Hash::make($validatedData['password']);
            }

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $filename = Str::uuid() . '.' . $foto->getClientOriginalExtension();
            
                // Simpan dulu nama file lama sebelum ditimpa
                $fotoLama = $user->foto;
            
                // Simpan file baru
                $foto->storeAs('foto', $filename, 'public');
            
                // Hapus file lama kalau ada
                if ($fotoLama && Storage::disk('public')->exists('foto/' . $fotoLama)) {
                    Storage::disk('public')->delete('foto/' . $fotoLama);
                }
            
                // Simpan nama file baru
                $user->foto = $filename;
            }            
            
            // Simpan perubahan ke database
            $user->save();

            // Tampilkan pesan sukses dan kembali ke halaman sebelumnya
            Alert::toast('Profile Berhasil Diubah!', 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tampilkan pesan error
            return back()->withInput()->with('error', 'Gagal mengubah profil. Pastikan input yang Anda masukkan benar.');
        }
    }
}