<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class PoliController extends Controller
{
    public function index()
    {
        return view('poli.index', [
            'title' => 'Poli',
            'poli' => Poli::all()
        ]);
    }

    public function create()
    {
        return view('poli.create', [
            'title' => 'Tambah Poli'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_poli'     => 'required|string|max:255',
        ]);
    
        try {
            Poli::create($validatedData);
            
            Alert::success('Sukses!', 'Data Berhasil Ditambah');
            return redirect()->route('poli.index');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan poli baru', ['error' => $e->getMessage()]);
            Alert::error('Error', 'Terjadi kesalahan saat menyimpan data');
            return back()->withInput();
        }
    }

    public function edit(Poli $poli)
    {
        return view('poli.edit', [
            'title' => 'Edit Poli',
            'poli' => $poli
        ]);
    }

    public function update(Request $request, Poli $poli)
    {
        $validatedData = $request->validate([
            'nama_poli'     => 'required|string|max:255',
        ]);
    
        try {
            $poli->update($validatedData);

            Alert::success('Sukses!', 'Data Berhasil Diupdate');
            return redirect()->route('poli.index');
        } catch (\Exception $e) {
            Log::error('Gagal update user', ['error' => $e->getMessage()]);
            Alert::error('Error', 'Terjadi kesalahan saat mengupdate data');
            return back()->withInput();
        }
    }

    public function destroy(Poli $poli)
    {
        try {
            $poli->delete();
    
            Alert::success('Berhasil', 'Data poli berhasil dihapus');
            return redirect()->route('poli.index');
        } catch (\Exception $e) {
            Log::error('Gagal hapus poli', ['error' => $e->getMessage()]);
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data');
            return back();
        }
    }
}