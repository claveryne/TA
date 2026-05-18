<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemeliharaan;
use App\Models\Ruangan;
use App\Models\Fasilitas;
use Illuminate\Support\Facades\Log;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;

class PemeliharaanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pemeliharaan = Pemeliharaan::when($search, function($query, $search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_pemeliharaan', 'like', "%{$search}%")
                  ->orWhere('jenis_pemeliharaan', 'like', "%{$search}%")
                  ->orWhere('biaya_pemeliharaan', 'like', "%{$search}%")
                  ->orWhere('jumlah_pemeliharaan', 'like', "%{$search}%")
                  ->orWhere('tglMulai_pemeliharaan', 'like', "%{$search}%")
                  ->orWhere('tglSelesai_pemeliharaan', 'like', "%{$search}%")
                  ->orWhere('keterangan_pemeliharaan', 'like', "%{$search}%")
                  ->orWhere('status_pemeliharaan', 'like', "%{$search}%");
            });
        })->get();

        $ruangan = Ruangan::all();
        $fasilitas = Fasilitas::where('jenis_fasilitas', '!=', 'Ruangan')->get();

        return view('admin.pemeliharaan', compact('pemeliharaan', 'search', 'ruangan', 'fasilitas'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_pemeliharaan'       => 'required|max:20',
                'jenis_pemeliharaan'      => 'required|max:20',
                'biaya_pemeliharaan'      => 'nullable|double',
                'jumlah_pemeliharaan'     => 'nullable|integer',
                'status_pemeliharaan'     => 'required|max:20',
                'tglMulai_pemeliharaan'   => 'required',
                'tglSelesai_pemeliharaan' => 'nullable',
                'bukti_pemeliharaan'      => 'nullable|image|mimes:jpg,png,jpeg|max:30720',
                'keterangan_pemeliharaan' => 'nullable',
            ]);

            Log::info('Mencoba menambahkan data pemeliharaan baru: ' . $request->nama_pemeliharaan);

            $fileName = null;
            if ($request->hasFile('bukti_pemeliharaan')) {
                $file = $request->file('bukti_pemeliharaan');
                $fileName = 'service_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/pemeliharaan'), $fileName);
            }

            $pemeliharaan = Pemeliharaan::create([
                'nama_pemeliharaan'      => $request->nama_pemeliharaan,
                'jenis_pemeliharaan'     => $request->jenis_pemeliharaan,
                'biaya_pemeliharaan'    => $request->biaya_pemeliharaan,
                'jumlah_pemeliharaan' => $request->jumlah_pemeliharaan,
                'status_pemeliharaan' => $request->status_pemeliharaan,
                'bukti_pemeliharaan'      => $fileName,
                'keterangan_pemeliharaan'=> $request->keterangan_pemeliharaan,
                'tglMulai_pemeliharaan'    => $request->tglMulai_pemeliharaan,
                'tglSelesai_pemeliharaan'    => $request->tglSelesai_pemeliharaan,
            ]);

            if (strpos($request->nama_pemeliharaan, 'Ruangan - ') === 0) {
                $statusUpdate = ($request->status_pemeliharaan == 'Berjalan') ? 'Pemeliharaan' : 'Tersedia';
                $nama_ruangan = substr($request->nama_pemeliharaan, 10);
                Ruangan::where('nama_ruangan', $nama_ruangan)->update(['status_ruangan' => $statusUpdate]);
                Fasilitas::where('nama_fasilitas', $nama_ruangan)->where('jenis_fasilitas', 'Ruangan')->update(['status_fasilitas' => $statusUpdate]);
            } else if (strpos($request->nama_pemeliharaan, 'Fasilitas - ') === 0) {
                $nama_fasilitas = substr($request->nama_pemeliharaan, 12);
                $fasilitas = Fasilitas::where('nama_fasilitas', $nama_fasilitas)->where('jenis_fasilitas', '!=', 'Ruangan')->first();
                if ($fasilitas) {
                    $totalActive = Pemeliharaan::where('nama_pemeliharaan', $request->nama_pemeliharaan)
                        ->where('status_pemeliharaan', 'Berjalan')
                        ->sum('jumlah_pemeliharaan');
                    
                    if ($totalActive >= $fasilitas->jumlah_fasilitas) {
                        $fasilitas->update(['status_fasilitas' => 'Pemeliharaan']);
                    } else {
                        $fasilitas->update(['status_fasilitas' => 'Tersedia']);
                    }
                }
            }

            Log::info('Data ruangan berhasil ditambahkan.', [
                'id_pemeliharaan'   => $pemeliharaan->id_pemeliharaan,
                'nama_pemeliharaan' => $pemeliharaan->nama_pemeliharaan,
            ]);

            return redirect()->back()->with('success', 'Data pemeliharaan berhasil ditambahkan!');

        } catch (Exception $e) {
            Log::error('GAGAL menambahkan data pemeliharaan.', [
                'error_message' => $e->getMessage(),
                'user_input'    => $request->except('bukti_pemeliharaan'),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                ->withInput(); 
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('Mencoba mengupdate data pemeliharaan: ' . $request->nama_pemeliharaan);

            $pemeliharaanOld = Pemeliharaan::find($id);

            $fileName = $pemeliharaanOld->bukti_pemeliharaan;
            if ($request->hasFile('bukti_pemeliharaan')) {
                $file = $request->file('bukti_pemeliharaan');
                $fileName = 'service_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/pemeliharaan'), $fileName);
            }

            $pemeliharaan = Pemeliharaan::where('id_pemeliharaan', $id)->update([
                'nama_pemeliharaan'      => $request->nama_pemeliharaan,
                'jenis_pemeliharaan'     => $request->jenis_pemeliharaan,
                'biaya_pemeliharaan'    => $request->biaya_pemeliharaan,
                'jumlah_pemeliharaan' => $request->jumlah_pemeliharaan,
                'status_pemeliharaan' => $request->status_pemeliharaan,
                'bukti_pemeliharaan'      => $fileName,
                'keterangan_pemeliharaan'=> $request->keterangan_pemeliharaan,
                'tglMulai_pemeliharaan'    => $request->tglMulai_pemeliharaan,
                'tglSelesai_pemeliharaan'    => $request->tglSelesai_pemeliharaan,
            ]);

            if (strpos($request->nama_pemeliharaan, 'Ruangan - ') === 0) {
                $statusUpdate = ($request->status_pemeliharaan == 'Berjalan') ? 'Pemeliharaan' : 'Tersedia';
                $nama_ruangan = substr($request->nama_pemeliharaan, 10);
                Ruangan::where('nama_ruangan', $nama_ruangan)->update(['status_ruangan' => $statusUpdate]);
                Fasilitas::where('nama_fasilitas', $nama_ruangan)->where('jenis_fasilitas', 'Ruangan')->update(['status_fasilitas' => $statusUpdate]);
            } else if (strpos($request->nama_pemeliharaan, 'Fasilitas - ') === 0) {
                $nama_fasilitas = substr($request->nama_pemeliharaan, 12);
                $fasilitas = Fasilitas::where('nama_fasilitas', $nama_fasilitas)->where('jenis_fasilitas', '!=', 'Ruangan')->first();
                if ($fasilitas) {
                    $totalActive = Pemeliharaan::where('nama_pemeliharaan', $request->nama_pemeliharaan)
                        ->where('status_pemeliharaan', 'Berjalan')
                        ->sum('jumlah_pemeliharaan');
                    
                    if ($totalActive >= $fasilitas->jumlah_fasilitas) {
                        $fasilitas->update(['status_fasilitas' => 'Pemeliharaan']);
                    } else {
                        $fasilitas->update(['status_fasilitas' => 'Tersedia']);
                    }
                }
            }

            Log::info('Data pemeliharaan berhasil diupdate.', [
                'id_pemeliharaan'   => $id,
                'nama_pemeliharaan' => $request->nama_pemeliharaan,
            ]);

            return redirect()->back()->with('success', 'Data pemeliharaan berhasil diupdate!');

        } catch (Exception $e) {
            Log::error('GAGAL mengupdate data pemeliharaan.', [
                'error_message' => $e->getMessage(),
                'user_input'    => $request->except('bukti_pemeliharaan'),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function cetakLaporan(Request $request)
    {
        $request->validate([
            'bulan' => 'required',
            'tahun' => 'required',
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $pemeliharaan = Pemeliharaan::whereMonth('tglMulai_pemeliharaan', $bulan)
                                    ->whereYear('tglMulai_pemeliharaan', $tahun)
                                    ->get();

        $totalBiaya = $pemeliharaan->sum('biaya_pemeliharaan');

        $namaBulan = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        $bulanStr = $namaBulan[$bulan] ?? $bulan;

        $pdf = Pdf::loadView('pdf.pemeliharaan', compact('pemeliharaan', 'bulanStr', 'tahun', 'totalBiaya'))
                  ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan_pemeliharaan_' . $bulan . '_' . $tahun . '.pdf');
    }
}
