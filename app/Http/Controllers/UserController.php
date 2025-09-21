<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.index', [
            'title' => 'Pengguna',
            'user' => User::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create', [
            'title' => 'Tambah Data User'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */   
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lengkap'     => 'required|string|max:255',
            'nama_panggilan'   => 'required|string|max:255',
            'jenis_kelamin'    => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'    => 'required|date',
            'no_hp'            => 'nullable|string|max:20',
            'alamat'           => 'nullable|string|max:255',
            'role'             => 'required|string|max:255',
            'username'         => 'required|string|max:255|unique:users,username',
            'email'             => 'required|email',
            'password'         => 'required|string|min:6',
            'foto'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:512',
        ]);
    
        try {
            // Simpan password dalam bentuk hash
            $validatedData['password'] = bcrypt($validatedData['password']);
    
            // Simpan data user TANPA foto dulu
            $user = User::create($validatedData);
    
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
            
                // Buat nama unik untuk file
                $filename = Str::uuid() . '.' . $foto->getClientOriginalExtension();
            
                // Simpan file ke folder 'foto' di storage/public, tapi hanya ambil nama file-nya
                $foto->storeAs('foto', $filename, 'public');
            
                // Simpan nama file-nya saja ke database
                $user->foto = $filename;
                $user->save();
            }
            
            Alert::success('Sukses!', 'Data Berhasil Ditambah');
            return redirect()->route('user.index');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan user baru', ['error' => $e->getMessage()]);
            Alert::error('Error', 'Terjadi kesalahan saat menyimpan data');
            return back()->withInput();
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('user.show', [
            'title' => 'Detail User',
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('user.edit', [
            'title' => 'Edit User',
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'nama_lengkap'     => 'required|string|max:255',
            'nama_panggilan'   => 'required|string|max:255',
            'jenis_kelamin'    => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'    => 'required|date',
            'no_hp'            => 'nullable|string|max:20',
            'alamat'           => 'nullable|string|max:255',
            'role'             => 'required|string|max:255',
            'username'         => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'             => 'required|email',
            'password'         => 'nullable|string|min:6',
            'foto'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:512',
        ]);
    
        try {
            // Simpan nama foto lama dulu
            $fotoLama = $user->foto;
    
            // Proses password
            if (!empty($validatedData['password'])) {
                $validatedData['password'] = bcrypt($validatedData['password']);
            } else {
                unset($validatedData['password']);
            }
    
            // Update user tanpa menyentuh foto dulu
            $user->update($validatedData);
    
            // Jika ada foto baru di-upload
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $filename = Str::uuid() . '.' . $foto->getClientOriginalExtension();
                $foto->storeAs('foto', $filename, 'public');
    
                // Hapus foto lama jika ada
                if ($fotoLama && Storage::disk('public')->exists('foto/' . $fotoLama)) {
                    Storage::disk('public')->delete('foto/' . $fotoLama);
                }
    
                // Simpan nama file baru
                $user->foto = $filename;
                $user->save();
            }
    
            Alert::success('Sukses!', 'Data Berhasil Diupdate');
            return redirect()->route('user.index');
        } catch (\Exception $e) {
            Log::error('Gagal update user', ['error' => $e->getMessage()]);
            Alert::error('Error', 'Terjadi kesalahan saat mengupdate data');
            return back()->withInput();
        }
    }    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            // Hapus file foto jika ada
            if ($user->foto && Storage::disk('public')->exists('foto/' . $user->foto)) {
                Storage::disk('public')->delete('foto/' . $user->foto);
            }
    
            $user->delete();
    
            Alert::success('Berhasil', 'Data pengguna berhasil dihapus');
            return redirect()->route('user.index');
        } catch (\Exception $e) {
            Log::error('Gagal hapus user', ['error' => $e->getMessage()]);
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data');
            return back();
        }
    }
    
}