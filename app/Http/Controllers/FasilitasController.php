<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fasilitas;
use App\Models\JenisFasilitas;
use App\Models\DetailSpesifikasi;
use Illuminate\Support\Facades\Log;

class FasilitasController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_fasilitas'      => 'required|max:255',
                'id_jenis'            => 'required|exists:jenis_fasilitas,id_jenis',
                'jumlah_fasilitas'    => 'required|integer|min:1',
                'foto_fasilitas'      => 'nullable|image|mimes:jpg,png,jpeg|max:30720',
                'keterangan_fasilitas'=> 'nullable|max:255',
                'status_fasilitas'    => 'required|max:20',
                
                'merk'     => 'nullable|string|max:255',
                'warna'    => 'nullable|string|max:255',
                'ukuran'   => 'nullable|string|max:100',
                'kapasitas'=> 'nullable|integer|min:1',
            ]);

            Log::info('Mencoba menambahkan data fasilitas baru: ' . $request->nama_fasilitas);

            $fileName = null;
            if ($request->hasFile('foto_fasilitas')) {
                $file = $request->file('foto_fasilitas');
                $fileName = 'facility_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/fasilitas'), $fileName);
            }

            $fasilitas = Fasilitas::create([
                'nama_fasilitas'       => $request->nama_fasilitas,
                'id_jenis'             => $request->id_jenis,
                'jumlah_fasilitas'     => $request->jumlah_fasilitas,
                'foto_fasilitas'       => $fileName,
                'keterangan_fasilitas' => $request->keterangan_fasilitas,
                'status_fasilitas'     => $request->status_fasilitas,
            ]);

            if ($request->merk || $request->warna || $request->ukuran || $request->kapasitas) {
                DetailSpesifikasi::create([
                    'id_fasilitas' => $fasilitas->id_fasilitas,
                    'merk'         => $request->merk,
                    'warna'        => $request->warna,
                    'ukuran'       => $request->ukuran,
                    'kapasitas'    => $request->kapasitas,
                ]);
            }

            Log::info('Data fasilitas berhasil ditambahkan.', [
                'id_fasilitas'  => $fasilitas->id_fasilitas,
                'nama_fasilitas'=> $fasilitas->nama_fasilitas,
            ]);

            return redirect()->back()->with('success', 'Data fasilitas berhasil ditambahkan!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->with('error', 'Terjadi kesalahan validasi: ' . implode(', ', $e->validator->errors()->all()))
                ->withInput();
        } catch (\Exception $e) {
            Log::error('GAGAL menambahkan data fasilitas.', [
                'error_message' => $e->getMessage(),
                'user_input'    => $request->except('foto_fasilitas'),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $jenis  = $request->input('jenis');
        $status = $request->input('status');

        $fasilitas = Fasilitas::with(['jenisFasilitas', 'detailSpesifikasi'])
            ->whereIn('status_fasilitas', ['Tersedia', 'Terpakai', 'Pemeliharaan'])
            ->when($jenis, function ($query, $jenis) {
                return $query->where('id_jenis', $jenis);
            })
            ->when($status, function ($query, $status) {
                return $query->where('status_fasilitas', $status);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_fasilitas', 'like', "%{$search}%")
                        ->orWhere('jumlah_fasilitas', 'like', "%{$search}%")
                        ->orWhere('keterangan_fasilitas', 'like', "%{$search}%")
                        ->orWhere('status_fasilitas', 'like', "%{$search}%")
                        ->orWhereHas('jenisFasilitas', function ($q2) use ($search) {
                            $q2->where('nama_jenis', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('updated_at', 'desc')
            ->get();

        $jenisFasilitas = JenisFasilitas::orderBy('nama_jenis')->get();

        return view('admin.fasilitas', compact('fasilitas', 'search', 'jenisFasilitas'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_fasilitas'      => 'required|max:255',
                'id_jenis'            => 'required|exists:jenis_fasilitas,id_jenis',
                'jumlah_fasilitas'    => 'required|integer|min:1',
                'foto_fasilitas'      => 'nullable|image|mimes:jpg,png,jpeg|max:30720',
                'keterangan_fasilitas'=> 'nullable|max:255',
                'status_fasilitas'    => 'required|max:20',
                
                'merk'     => 'nullable|string|max:255',
                'warna'    => 'nullable|string|max:255',
                'ukuran'   => 'nullable|string|max:100',
                'kapasitas'=> 'nullable|integer|min:1',
            ]);

            Log::info('Mencoba mengupdate data fasilitas ID: ' . $id);

            $fasilitasOld = Fasilitas::find($id);

            $fileName = $fasilitasOld->foto_fasilitas;
            if ($request->hasFile('foto_fasilitas')) {
                if ($fasilitasOld->foto_fasilitas && file_exists(public_path('uploads/fasilitas/' . $fasilitasOld->foto_fasilitas))) {
                    @unlink(public_path('uploads/fasilitas/' . $fasilitasOld->foto_fasilitas));
                }

                $file = $request->file('foto_fasilitas');
                $fileName = 'facility_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/fasilitas'), $fileName);
            }

            Fasilitas::where('id_fasilitas', $id)->update([
                'nama_fasilitas'       => $request->nama_fasilitas,
                'id_jenis'             => $request->id_jenis,
                'jumlah_fasilitas'     => $request->jumlah_fasilitas,
                'foto_fasilitas'       => $fileName,
                'keterangan_fasilitas' => $request->keterangan_fasilitas,
                'status_fasilitas'     => $request->status_fasilitas,
            ]);

            DetailSpesifikasi::updateOrCreate(
                ['id_fasilitas' => $id],
                [
                    'merk'     => $request->merk,
                    'warna'    => $request->warna,
                    'ukuran'   => $request->ukuran,
                    'kapasitas'=> $request->kapasitas,
                ]
            );

            Log::info('Data fasilitas berhasil diupdate.', [
                'id_fasilitas'  => $id,
                'nama_fasilitas'=> $request->nama_fasilitas,
            ]);

            return redirect()->back()->with('success', 'Data fasilitas berhasil diupdate!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->with('error', 'Terjadi kesalahan validasi: ' . implode(', ', $e->validator->errors()->all()))
                ->withInput();
        } catch (\Exception $e) {
            Log::error('GAGAL mengupdate data fasilitas.', [
                'error_message' => $e->getMessage(),
                'user_input'    => $request->except('foto_fasilitas'),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $fasilitas = Fasilitas::findOrFail($id);
            $fasilitas->delete();

            Log::info('Data fasilitas berhasil dihapus (soft delete).', ['id_fasilitas' => $id]);

            return redirect()->back()->with('success', 'Data fasilitas berhasil dihapus dari tampilan!');
        } catch (\Exception $e) {
            Log::error('GAGAL menghapus data fasilitas.', ['error_message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal menghapus data fasilitas: ' . $e->getMessage());
        }
    }

    public function storeJenis(Request $request)
    {
        try {
            $request->validate([
                'nama_jenis' => 'required|string|max:255',
            ]);

            JenisFasilitas::create([
                'nama_jenis' => $request->nama_jenis,
            ]);

            return redirect()->back()->with('success', 'Jenis fasilitas berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan jenis fasilitas: ' . $e->getMessage());
        }
    }

    public function updateJenis(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_jenis' => 'required|string|max:255',
            ]);

            $jenis = JenisFasilitas::findOrFail($id);
            $jenis->update([
                'nama_jenis' => $request->nama_jenis,
            ]);

            return redirect()->back()->with('success', 'Jenis fasilitas berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupdate jenis fasilitas: ' . $e->getMessage());
        }
    }

    public function deleteJenis($id)
    {
        try {
            $jenis = JenisFasilitas::findOrFail($id);
            $jenis->delete();

            return redirect()->back()->with('success', 'Jenis fasilitas berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus jenis fasilitas: ' . $e->getMessage());
        }
    }
}
