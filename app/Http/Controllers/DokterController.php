<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class DokterController extends Controller
{
    public function index()
    {
        return view('dokter.index', [
            'title' => 'Dokter',
            'dokter' => Dokter::with('poli')->get()
        ]);
    }

    public function create()
    {
        return view('dokter.create', [
            'title' => 'Tambah Dokter',
            'poli' => Poli::all()
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_dokter'    => 'required|string|max:255',
            'poli_id'        => 'required|exists:poli,id',
            'no_str'         => 'nullable|string|max:255',
            'no_sip'         => 'nullable|string|max:255',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'  => 'nullable|date',
            'alamat'         => 'nullable|string',
        ]);

        try {
            Dokter::create($validatedData);

            Alert::success('Sukses!', 'Data Dokter Berhasil Ditambah');
            return redirect()->route('dokter.index');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan dokter baru', ['error' => $e->getMessage()]);
            Alert::error('Error', 'Terjadi kesalahan saat menyimpan data');
            return back()->withInput();
        }
    }

    public function edit(Dokter $dokter)
    {
        return view('dokter.edit', [
            'title' => 'Edit Dokter',
            'dokter' => $dokter,
            'poli' => Poli::all()
        ]);
    }

    public function update(Request $request, Dokter $dokter)
    {
        $validatedData = $request->validate([
            'nama_dokter'    => 'required|string|max:255',
            'poli_id'        => 'required|exists:poli,id',
            'no_str'         => 'nullable|string|max:255',
            'no_sip'         => 'nullable|string|max:255',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'  => 'nullable|date',
            'alamat'         => 'nullable|string',
        ]);

        try {
            $dokter->update($validatedData);

            Alert::success('Sukses!', 'Data Dokter Berhasil Diperbarui');
            return redirect()->route('dokter.index');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data dokter', ['error' => $e->getMessage()]);
            Alert::error('Error', 'Terjadi kesalahan saat memperbarui data');
            return back()->withInput();
        }
    }
}