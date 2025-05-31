<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pasien;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pasien.index', [
            'title' => 'Pasien',
            'pasien' => Pasien::with('user')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pasien.create', [
            'title' => 'Tambah Pasien'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lengkap'       => 'required|string|max:255',
            'nama_panggilan'     => 'required|string|max:255',
            'nik'                => 'required|string|max:20|unique:pasien,nik|unique:users,username',
            'jenis_kelamin'      => 'required|in:Laki-laki,Perempuan',
            'no_hp'              => 'required|string|max:20',
            'tempat_lahir'       => 'nullable|string|max:100',
            'tanggal_lahir'      => 'nullable|date',
            'alamat'             => 'nullable|string|max:255',
            'pekerjaan'          => 'nullable|string|max:100',
            'status_perkawinan'  => 'nullable|in:Belum Menikah,Menikah,Cerai',
            'golongan_darah'     => 'nullable|in:A,B,AB,O',
            'agama'              => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'foto'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:512',
        ]);
    
        try {
            // Generate no_rm
            $lastPasien = Pasien::orderBy('id', 'desc')->first();
            $lastNumber = 0;
        
            if ($lastPasien && preg_match('/RM-(\d+)/', $lastPasien->no_rm, $matches)) {
                $lastNumber = (int) $matches[1];
            }
        
            $newNumber = $lastNumber + 1;
            $no_rm = 'RM-' . str_pad($newNumber, 2, '0', STR_PAD_LEFT);
        
            // Inisialisasi model pasien
            $pasien = new Pasien($validatedData);
            $pasien->no_rm = $no_rm;
        
            // Simpan data pasien terlebih dahulu
            $pasien->save();
        
            // Simpan data ke tabel users
            $user = new User();
            $user->nama_lengkap     = $validatedData['nama_lengkap'];
            $user->nama_panggilan   = $validatedData['nama_panggilan'];
            $user->jenis_kelamin    = $validatedData['jenis_kelamin'];
            $user->tanggal_lahir    = $validatedData['tanggal_lahir'] ?? null;
            $user->no_hp            = $validatedData['no_hp'] ?? null;
            $user->alamat           = $validatedData['alamat'] ?? null;
            $user->username         = $validatedData['nik'];

            // Ambil nama_panggilan, ubah ke lowercase
            $namaPanggilan = strtolower($validatedData['nama_panggilan']);

            // Hilangkan semua spasi dan tanda baca
            $namaPanggilanBersih = preg_replace('/[\s\p{P}]+/u', '', $namaPanggilan);

            // Hash password dari nama_panggilan yang sudah dibersihkan
            $user->password = Hash::make($namaPanggilanBersih);
            
            $user->role             = 'Pasien';

            // Proses upload foto jika ada
            $filename = null;
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $filename = Str::uuid() . '.' . $foto->getClientOriginalExtension();
                $foto->storeAs('foto', $filename, 'public');
            }
        
            if ($filename) {
                $user->foto = $filename;
            }
        
            $user->save();
        
            // Tambahkan user_id ke pasien setelah user disimpan
            $pasien->user_id = $user->id;
            $pasien->save();
        
            Alert::success('Sukses!', 'Data pasien & user berhasil ditambahkan');
            return redirect()->route('pasien.index');
        
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan user baru', ['error' => $e->getMessage()]);
            Alert::error('Error', 'Terjadi kesalahan saat menyimpan data');
            return back()->withInput();
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Pasien $pasien)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pasien $pasien)
    {
        return view('pasien.edit', [
            'title' => 'Edit Pasien',
            'pasien' => $pasien,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pasien $pasien)
    {
        $validatedData = $request->validate([
            'nama_lengkap'       => 'required|string|max:255',
            'nama_panggilan'     => 'required|string|max:255',
            'jenis_kelamin'      => 'required|in:Laki-laki,Perempuan',
            'no_hp'              => 'required|string|max:20',
            'tempat_lahir'       => 'nullable|string|max:100',
            'tanggal_lahir'      => 'nullable|date',
            'alamat'             => 'nullable|string|max:255',
            'pekerjaan'          => 'nullable|string|max:100',
            'status_perkawinan'  => 'nullable|in:Belum Menikah,Menikah,Cerai',
            'golongan_darah'     => 'nullable|in:A,B,AB,O',
            'agama'              => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'foto'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:512',
        ]);
    
        try {
            // Update data pasien
            $pasien->update($validatedData);
    
            // Update data user yang terhubung
            $user = $pasien->user;
    
            if ($user) {
                $user->nama_lengkap     = $validatedData['nama_lengkap'];
                $user->nama_panggilan   = $validatedData['nama_panggilan'];
                $user->jenis_kelamin    = $validatedData['jenis_kelamin'];
                $user->tanggal_lahir    = $validatedData['tanggal_lahir'] ?? null;
                $user->no_hp            = $validatedData['no_hp'] ?? null;
                $user->alamat           = $validatedData['alamat'] ?? null;
    
                // Jika ada foto baru di-upload
                if ($request->hasFile('foto')) {
                    $foto = $request->file('foto');
                    $filename = Str::uuid() . '.' . $foto->getClientOriginalExtension();
                    $foto->storeAs('foto', $filename, 'public');
    
                    // Hapus foto lama jika ada
                    if ($user->foto && Storage::disk('public')->exists('foto/' . $user->foto)) {
                        Storage::disk('public')->delete('foto/' . $user->foto);
                    }
    
                    $user->foto = $filename;
                }
    
                $user->save();
            }
    
            Alert::success('Sukses!', 'Data pasien berhasil diperbarui');
            return redirect()->route('pasien.index');
    
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data pasien', ['error' => $e->getMessage()]);
            Alert::error('Error', 'Terjadi kesalahan saat memperbarui data');
            return back()->withInput();
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pasien $pasien)
    {
        try {
            // Jika user terhubung, hapus foto dan akun user
            if ($pasien->user) {
                if ($pasien->user->foto && Storage::disk('public')->exists('foto/' . $pasien->user->foto)) {
                    Storage::disk('public')->delete('foto/' . $pasien->user->foto);
                }
    
                $pasien->user->delete(); // Hapus akun user
            }
    
            $pasien->delete(); // Hapus data pasien
    
            Alert::success('Berhasil', 'Data pasien & akun berhasil dihapus');
            return redirect()->route('pasien.index');
        } catch (\Exception $e) {
            Log::error('Gagal hapus user', ['error' => $e->getMessage()]);
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data');
            return back();
        }
    }

    public function hubungkanAkunForm($id)
    {
        $pasien = Pasien::findOrFail($id);
        $users = User::where('role', 'pasien')->whereDoesntHave('pasien')->get();

        return view('pasien.hubungkan-akun', [
            'title' => 'Hubungkan Akun',
            'pasien' => $pasien,
            'users' => $users
        ]);
    }

    public function hubungkanAkun(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $pasien = Pasien::findOrFail($id);
        $pasien->user_id = $request->user_id;
        $pasien->save();

        Alert::success('Berhasil', 'Akun berhasil dihubungkan.');
        return redirect()->route('pasien.index');
    }
    
}