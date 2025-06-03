<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('obat.supplier.index', [
            'title' => 'Supplier',
            'supplier' => Supplier::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('obat.supplier.create', [
            'title' => 'Tambah Supplier'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_supplier'    => 'required|string|max:255',
            'telepon'          => 'nullable|string|max:20',
            'alamat'           => 'nullable|string|max:255',
        ]);
    
        try {
            Supplier::create($validatedData);

            Alert::success('Sukses!', 'Data Berhasil Ditambah');
            return redirect()->route('obat.supplier.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat menyimpan data');
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('obat.supplier.edit', [
            'title' => 'Edit Supplier',
            'supplier' => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validatedData = $request->validate([
            'nama_supplier'     => 'required|string|max:255',
            'telepon'           => 'nullable|string|max:255',
            'alamat'            => 'nullable|string|max:255',
        ]);
    
        try {
            $supplier->update($validatedData);
    
            Alert::success('Sukses!', 'Data Berhasil Diupdate');
            return redirect()->route('obat.supplier.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat mengupdate data');
            return back()->withInput();
        }
    } 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        try { 
            $supplier->delete();
    
            Alert::success('Berhasil', 'Data berhasil dihapus');
            return redirect()->route('obat.supplier.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data');
            return back();
        }
    }
}