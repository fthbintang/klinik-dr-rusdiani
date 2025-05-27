<?php

namespace App\Http\Controllers;

use App\Models\JadwalDokter;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class JadwalDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('jadwal_dokter.index', [
            'title' => 'Jadwal Dokter',
            'jadwal_dokter' => JadwalDokter::all()->keyBy('hari'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $jadwalData = $request->input('jadwal', []);
    
        $rules = [];
        foreach ($jadwalData as $index => $data) {
            if (isset($data['aktif'])) {
                $rules["jadwal.$index.jam_mulai"] = 'required';
                $rules["jadwal.$index.jam_selesai"] = 'required';
            }
        }
    
        $messages = [
            'required' => 'Wajib diisi.',
        ];
    
        // Buat validator manual supaya bisa tambah error custom
        $validator = Validator::make($request->all(), $rules, $messages);
    
        // Validasi custom: jam_mulai harus lebih awal dari jam_selesai
        $validator->after(function ($validator) use ($jadwalData) {
            foreach ($jadwalData as $index => $data) {
                if (isset($data['aktif'])) {
                    $jamMulai = $data['jam_mulai'] ?? null;
                    $jamSelesai = $data['jam_selesai'] ?? null;
    
                    if ($jamMulai && $jamSelesai && strtotime($jamMulai) >= strtotime($jamSelesai)) {
                        $validator->errors()->add(
                            "jadwal.$index.jam_mulai",
                            'Jam mulai harus lebih awal dari jam selesai.'
                        );
                    }
                }
            }
        });
    
        $validator->validate(); // akan otomatis redirect jika ada error
    
        // Proses simpan dan hapus berdasarkan data asli (bukan hasil validasi)
        foreach ($jadwalData as $data) {
            $hari = $data['hari'];
    
            if (isset($data['aktif'])) {
                JadwalDokter::updateOrCreate(
                    ['hari' => $hari],
                    [
                        'jam_mulai' => $data['jam_mulai'],
                        'jam_selesai' => $data['jam_selesai'],
                    ]
                );
            } else {
                JadwalDokter::where('hari', $hari)->delete();
            }
        }
    
        Alert::success('Sukses!', 'Jadwal dokter berhasil diperbarui.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(JadwalDokter $jadwalDokter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JadwalDokter $jadwalDokter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JadwalDokter $jadwalDokter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JadwalDokter $jadwalDokter)
    {
        //
    }
}