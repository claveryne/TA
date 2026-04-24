<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fasilitas;
use App\Models\DetailMulmed;
use App\Models\DetailSound;
use App\Models\DetailLighting;
use App\Models\DetailMusik;
use App\Models\DetailUmum;
use App\Models\DetailRuang;
use Illuminate\Support\Facades\Log;

class FasilitasController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_fasilitas' => 'required|max:255',
                'jenis_fasilitas' => 'required|max:20',
                'jumlah_fasilitas' => 'required|integer',
                'merk_fasilitas' => 'required|max:255',
                'foto_fasilitas' => 'nullable|image|mimes:jpg,png,jpeg|max:30720',
                'keterangan_fasilitas' => 'nullable|max:255',
                'status_fasilitas' => 'required|max:20',

                // Detail fasilitas
                'warnaMM' => 'nullable|string|max:255',
                'warnaS' => 'nullable|string|max:255',
                'warnaL' => 'nullable|string|max:255',
                'warnaM' => 'nullable|string|max:255',
                'warnaU' => 'nullable|string|max:255',
                'ukuranU' => 'nullable|integer',
                'ukuranR' => 'nullable|integer',
                'kapasitasR' => 'nullable|integer',
            ]);

        
            Log::info('Mencoba menambahkan data fasilitas baru: ' . $request->nama_fasilitas);

            $fileName = null;
            if ($request->hasFile('foto_fasilitas')) {
                $file = $request->file('foto_fasilitas');
                $fileName = 'facility_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/fasilitas'), $fileName);
            }

            $fasilitas = Fasilitas::create([
                'nama_fasilitas' => $request->nama_fasilitas,
                'jenis_fasilitas' => $request->jenis_fasilitas,
                'jumlah_fasilitas' => $request->jumlah_fasilitas,
                'merk_fasilitas' => $request->merk_fasilitas,
                'foto_fasilitas' => $fileName,
                'keterangan_fasilitas' => $request->keterangan_fasilitas,
                'status_fasilitas' => $request->status_fasilitas,
            ]);

            // Save detail based on jenis_fasilitas
            if ($request->jenis_fasilitas === 'Multimedia') {
                DetailMulmed::create(['id_fasilitas' => $fasilitas->id_fasilitas, 'warnaMM' => $request->warnaMM]);
            } elseif ($request->jenis_fasilitas === 'Sound System') {
                DetailSound::create(['id_fasilitas' => $fasilitas->id_fasilitas, 'warnaS' => $request->warnaS]);
            } elseif ($request->jenis_fasilitas === 'Lighting') {
                DetailLighting::create(['id_fasilitas' => $fasilitas->id_fasilitas, 'warnaL' => $request->warnaL]);
            } elseif ($request->jenis_fasilitas === 'Alat Musik') {
                DetailMusik::create(['id_fasilitas' => $fasilitas->id_fasilitas, 'warnaM' => $request->warnaM]);
            } elseif ($request->jenis_fasilitas === 'Umum') {
                DetailUmum::create(['id_fasilitas' => $fasilitas->id_fasilitas, 'warnaU' => $request->warnaU, 'ukuranU' => $request->ukuranU]);
            } elseif ($request->jenis_fasilitas === 'Ruangan') {
                DetailRuang::create(['id_fasilitas' => $fasilitas->id_fasilitas, 'ukuranR' => $request->ukuranR, 'kapasitasR' => $request->kapasitasR]);
            }


            Log::info('Data fasilitas berhasil ditambahkan.', [
                'id_fasilitas' => $fasilitas->id_fasilitas,
                'nama_fasilitas' => $fasilitas->nama_fasilitas,
            ]);

            return redirect()->back()->with('success', 'Data fasilitas berhasil ditambahkan!');

        } catch (\Exception $e) {
            Log::error('GAGAL menambahkan data fasilitas.', [
                'error_message' => $e->getMessage(),
                'user_input' => $request->except('foto_fasilitas'),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $jenis = $request->input('jenis');
        $status = $request->input('status');
        $sortNama = $request->input('sort_nama');

        $fasilitas = Fasilitas::with(['detailMM', 'detailL', 'detailM', 'detailR', 'detailS', 'detailU'])
            ->whereIn('status_fasilitas', ['Tersedia', 'Terpakai', 'Pemeliharaan'])
            ->when($jenis, function ($query, $jenis) {
                return $query->where('jenis_fasilitas', $jenis);
            })
            ->when($status, function ($query, $status) {
                return $query->where('status_fasilitas', $status);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_fasilitas', 'like', "%{$search}%")
                        ->orWhere('jenis_fasilitas', 'like', "%{$search}%")
                        ->orWhere('jumlah_fasilitas', 'like', "%{$search}%")
                        ->orWhere('merk_fasilitas', 'like', "%{$search}%")
                        ->orWhere('keterangan_fasilitas', 'like', "%{$search}%")
                        ->orWhere('status_fasilitas', 'like', "%{$search}%");
                });
            })
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.fasilitas', compact('fasilitas', 'search'));
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('Mencoba mengupdate data fasilitas: ' . $request->nama_fasilitas);

            $fasilitasOld = Fasilitas::find($id);

            $fileName = $fasilitasOld->foto_fasilitas;
            if ($request->hasFile('foto_fasilitas')) {
                $file = $request->file('foto_fasilitas');
                $fileName = 'facility_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/fasilitas'), $fileName);
            }

            Fasilitas::where('id_fasilitas', $id)->update([
                'nama_fasilitas' => $request->nama_fasilitas,
                'jenis_fasilitas' => $request->jenis_fasilitas,
                'jumlah_fasilitas' => $request->jumlah_fasilitas,
                'merk_fasilitas' => $request->merk_fasilitas,
                'foto_fasilitas' => $fileName,
                'keterangan_fasilitas' => $request->keterangan_fasilitas,
                'status_fasilitas' => $request->status_fasilitas,
            ]);

            // Hapus detail lama jika ada perubahan jenis
            if ($fasilitasOld->jenis_fasilitas !== $request->jenis_fasilitas) {
                if ($fasilitasOld->jenis_fasilitas === 'Multimedia') {
                    DetailMulmed::where('id_fasilitas', $id)->delete();
                } elseif ($fasilitasOld->jenis_fasilitas === 'Sound System') {
                    DetailSound::where('id_fasilitas', $id)->delete();
                } elseif ($fasilitasOld->jenis_fasilitas === 'Lighting') {
                    DetailLighting::where('id_fasilitas', $id)->delete();
                } elseif ($fasilitasOld->jenis_fasilitas === 'Alat Musik') {
                    DetailMusik::where('id_fasilitas', $id)->delete();
                } elseif ($fasilitasOld->jenis_fasilitas === 'Umum') {
                    DetailUmum::where('id_fasilitas', $id)->delete();
                } elseif ($fasilitasOld->jenis_fasilitas === 'Ruangan') {
                    DetailRuang::where('id_fasilitas', $id)->delete();
                }
            }

            if ($request->jenis_fasilitas === 'Multimedia') {
                DetailMulmed::updateOrCreate(['id_fasilitas' => $id], ['warnaMM' => $request->warnaMM]);
            } elseif ($request->jenis_fasilitas === 'Sound System') {
                DetailSound::updateOrCreate(['id_fasilitas' => $id], ['warnaS' => $request->warnaS]);
            } elseif ($request->jenis_fasilitas === 'Lighting') {
                DetailLighting::updateOrCreate(['id_fasilitas' => $id], ['warnaL' => $request->warnaL]);
            } elseif ($request->jenis_fasilitas === 'Alat Musik') {
                DetailMusik::updateOrCreate(['id_fasilitas' => $id], ['warnaM' => $request->warnaM]);
            } elseif ($request->jenis_fasilitas === 'Umum') {
                DetailUmum::updateOrCreate(['id_fasilitas' => $id], ['warnaU' => $request->warnaU, 'ukuranU' => $request->ukuranU]);
            } elseif ($request->jenis_fasilitas === 'Ruangan') {
                DetailRuang::updateOrCreate(['id_fasilitas' => $id], ['ukuranR' => $request->ukuranR, 'kapasitasR' => $request->kapasitasR]);
            }


            Log::info('Data fasilitas berhasil diupdate.', [
                'id_fasilitas' => $id,
                'nama_fasilitas' => $request->nama_fasilitas,
            ]);

            return redirect()->back()->with('success', 'Data fasilitas berhasil diupdate!');

        } catch (\Exception $e) {
            Log::error('GAGAL mengupdate data fasilitas.', [
                'error_message' => $e->getMessage(),
                'user_input' => $request->except('foto_fasilitas'),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                ->withInput();
        }
    }
}
