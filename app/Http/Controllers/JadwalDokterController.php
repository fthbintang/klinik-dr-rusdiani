<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\JadwalDokter;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class JadwalDokterController extends Controller
{
    public function index(Request $request)
    {
        // Semua dokter untuk dropdown
        $dokterList = Dokter::all();

        $selectedDokter = null;
        $jadwal_dokter = [];

        // Jika ada dokter_id yang dipilih
        if ($request->has('dokter_id') && $request->dokter_id) {
            $selectedDokter = Dokter::find($request->dokter_id);

            if ($selectedDokter) {
                // Ambil jadwal dokter dan keyBy hari
                $jadwal_dokter = JadwalDokter::where('dokter_id', $selectedDokter->id)
                    ->get()
                    ->keyBy('hari');
            }
        }

        return view('jadwal_dokter.index', [
            'title' => 'Jadwal Dokter',
            'dokterList' => $dokterList,
            'selectedDokter' => $selectedDokter,
            'jadwal_dokter' => $jadwal_dokter,
        ]);
    }

    public function store(Request $request)
    {
        $dokterId = $request->input('dokter_id');
        $jadwalData = $request->input('jadwal', []);

        if (!$dokterId) {
            Alert::error('Error', 'Dokter belum dipilih.');
            return redirect()->back();
        }

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

        // Validator manual
        $validator = Validator::make($request->all(), $rules, $messages);

        // Validasi jam mulai < jam selesai
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

        $validator->validate(); // redirect jika error

        // Simpan atau hapus jadwal berdasarkan dokter_id
        foreach ($jadwalData as $data) {
            $hari = $data['hari'];

            if (isset($data['aktif'])) {
                JadwalDokter::updateOrCreate(
                    [
                        'dokter_id' => $dokterId,
                        'hari' => $hari
                    ],
                    [
                        'jam_mulai' => $data['jam_mulai'],
                        'jam_selesai' => $data['jam_selesai'],
                    ]
                );
            } else {
                JadwalDokter::where('dokter_id', $dokterId)
                    ->where('hari', $hari)
                    ->delete();
            }
        }

        Alert::success('Sukses!', 'Jadwal dokter berhasil diperbarui.');
        return redirect()->back();
    }
}