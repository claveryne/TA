<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\Ruangan;

class RuanganController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_ruangan'      => 'required|max:20',
                'jenis_ruangan'     => 'required|max:20',
                'ukuran_ruangan'    => 'required|numeric',
                'kapasitas_ruangan' => 'required|integer',
                'foto_ruangan'      => 'nullable|image|mimes:jpg,png,jpeg|max:30720',
                'keterangan_ruangan'=> 'nullable|max:255',
                'status_ruangan'    => 'required|max:20',
            ]);

            Log::info('Mencoba menambahkan data ruangan baru: ' . $request->nama_ruangan);

            $fileName = null;
            if ($request->hasFile('foto_ruangan')) {
                $file = $request->file('foto_ruangan');
                $fileName = 'room_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/ruangan'), $fileName);
            }

            $ruangan = Ruangan::create([
                'nama_ruangan'      => $request->nama_ruangan,
                'jenis_ruangan'     => $request->jenis_ruangan,
                'ukuran_ruangan'    => $request->ukuran_ruangan,
                'kapasitas_ruangan' => $request->kapasitas_ruangan,
                'foto_ruangan'      => $fileName,
                'keterangan_ruangan'=> $request->keterangan_ruangan,
                'status_ruangan'    => $request->status_ruangan,
            ]);

            Log::info('Data ruangan berhasil ditambahkan.', [
                'id_ruangan'   => $ruangan->id_ruangan,
                'nama_ruangan' => $ruangan->nama_ruangan,
            ]);

            return redirect()->back()->with('success', 'Data ruangan berhasil ditambahkan!');

        } catch (Exception $e) {
            Log::error('GAGAL menambahkan data ruangan.', [
                'error_message' => $e->getMessage(),
                'user_input'    => $request->except('foto_ruangan'),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                ->withInput(); 
        }
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $ruangan = Ruangan::whereIn('status_ruangan', ['Tersedia', 'Terpakai', 'Pemeliharaan'])
        ->when($search, function($query, $search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_ruangan', 'like', "%{$search}%")
                  ->orWhere('jenis_ruangan', 'like', "%{$search}%")
                  ->orWhere('ukuran_ruangan', 'like', "%{$search}%")
                  ->orWhere('kapasitas_ruangan', 'like', "%{$search}%")
                  ->orWhere('keterangan_ruangan', 'like', "%{$search}%")
                  ->orWhere('status_ruangan', 'like', "%{$search}%");
            });
        })->get();

        return view('admin.ruangan', compact('ruangan', 'search'));
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('Mencoba mengupdate data ruangan: ' . $request->nama_ruangan);

            $ruanganOld = Ruangan::find($id);

            $fileName = $ruanganOld->foto_ruangan;
            if ($request->hasFile('foto_ruangan')) {
                $file = $request->file('foto_ruangan');
                $fileName = 'room_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/ruangan'), $fileName);
            }

            $ruangan = Ruangan::where('id_ruangan', $id)->update([
                'nama_ruangan'      => $request->nama_ruangan,
                'jenis_ruangan'     => $request->jenis_ruangan,
                'ukuran_ruangan'    => $request->ukuran_ruangan,
                'kapasitas_ruangan' => $request->kapasitas_ruangan,
                'foto_ruangan'      => $fileName,
                'keterangan_ruangan'=> $request->keterangan_ruangan,
                'status_ruangan'    => $request->status_ruangan,
            ]);

            Log::info('Data ruangan berhasil diupdate.', [
                'id_ruangan'   => $id,
                'nama_ruangan' => $request->nama_ruangan,
            ]);

            return redirect()->back()->with('success', 'Data ruangan berhasil diupdate!');

        } catch (Exception $e) {
            Log::error('GAGAL mengupdate data ruangan.', [
                'error_message' => $e->getMessage(),
                'user_input'    => $request->except('foto_ruangan'),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                ->withInput();
        }
    }
}
