<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Supplier;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('obat.index', [
            'title' => 'Obat',
            'obat' => Obat::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('obat.create', [
            'title' => 'Tambah Obat',
            'supplier' => Supplier::latest()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_obat'     => 'required|string|max:255',
            'kategori'      => 'required|string|max:255',
            'satuan'        => 'required|string|max:255',
            'stok'          => 'required|integer|min:0',
            'harga'         => 'required|integer|min:0',
            'expired_date'  => 'required|date',
            'supplier_id'   => 'nullable|exists:supplier,id',
            'keterangan'    => 'nullable|string',
            'obat_bebas'    => 'required|boolean',
        ]);
    
        try {
            Obat::create($validatedData);

            Alert::success('Sukses!', 'Data Berhasil Ditambah');
            return redirect()->route('obat.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat menyimpan data');
            return back()->withInput();
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Obat $obat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Obat $obat)
    {
        return view('obat.edit', [
            'title' => 'Edit Obat',
            'supplier' => Supplier::latest()->get(),
            'obat' => $obat
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Obat $obat)
    {
        $validatedData = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kategori' => 'required|string',
            'satuan' => 'required|string',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|integer|min:0',
            'expired_date' => 'required|date',
            'supplier_id' => 'nullable|exists:supplier,id',
            'keterangan' => 'nullable|string',
        ]);
    
        try {
            $obat->update($validatedData);
    
            Alert::success('Sukses!', 'Data Berhasil Diupdate');
            return redirect()->route('obat.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat mengupdate data');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Obat $obat)
    {
        try { 
            $obat->delete();
    
            Alert::success('Berhasil', 'Data berhasil dihapus');
            return redirect()->route('obat.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data');
            return back();
        }
    }
}