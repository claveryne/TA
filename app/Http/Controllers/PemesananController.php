<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Pemeliharaan;
use App\Models\DetailFasilitas;
use App\Models\Ruangan;
use App\Models\Fasilitas;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminNotificationMail;
use App\Mail\CustomerStatusMail;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;

class PemesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemesanan::with(['ruangan', 'detailF.fasilitas']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_nota', 'like', "%{$search}%")
                    ->orWhere('nama_pemesan', 'like', "%{$search}%")
                    ->orWhere('nama_acara', 'like', "%{$search}%")
                    ->orWhere('tgl_mulai', 'like', "%{$search}%")
                    ->orWhere('tgl_selesai', 'like', "%{$search}%")
                    ->orWhereHas('ruangan', function ($q) use ($search) {
                        $q->where('nama_ruangan', 'like', "%{$search}%");
                    });
            });
        }

        $activeTab = $request->input('tab', 'semua');

        if ($activeTab == 'menunggu') {
            $query->where('status_pemesanan', 'Menunggu');
        } elseif ($activeTab == 'disetujui') {
            $query->where('status_pemesanan', 'Disetujui');
        } elseif ($activeTab == 'selesai') {
            $query->where('status_pemesanan', 'Selesai');
        } elseif ($activeTab == 'dibatalkan') {
            $query->whereIn('status_pemesanan', ['Dibatalkan', 'Ditolak']);
        }

        $pemesanans = $query->orderBy('updated_at', 'desc')->get();
        $ruangans = Ruangan::where('status_ruangan', 'Tersedia')->get();
        $fasilitases = Fasilitas::where('status_fasilitas', 'Tersedia')->get()->groupBy('jenis_fasilitas');
        return view('admin.pemesanan', compact('pemesanans', 'activeTab', 'ruangans', 'fasilitases'));
    }

    public function calendar()
    {
        $roomColors = [
            1 => '#F5CCA0',
            2 => '#994D1C',
            3 => '#6B240D',
        ];

        $events = Pemesanan::with('ruangan')
            ->whereNotIn('status_pemesanan', ['Dibatalkan', 'Ditolak', 'Selesai'])
            ->get()
            ->map(function ($booking) use ($roomColors) {
                $title = $booking->ruangan->nama_ruangan . ": Booked";

                $color = $roomColors[$booking->id_ruangan] ?? '#6B240D';

                return [
                    'title' => $title,
                    'start' => $booking->tgl_mulai,
                    'end' => date('Y-m-d', strtotime($booking->tgl_selesai . ' +1 day')),
                    'color' => $color,
                    'allDay' => true
                ];
            });

        // 1. Pesanan Baru
        $pesananBaruCount = Pemesanan::where('status_pemesanan', 'Menunggu')->count();

        // 2. Pesanan Berjalan (Disetujui) grouped by name (show 0 if no booking)
        $pesananBerjalanCount = Pemesanan::where('status_pemesanan', 'Disetujui')->count();
        $ruangansList = Ruangan::orderBy('id_ruangan')->get();
        $pesananBerjalanStats = collect();
        foreach ($ruangansList as $r) {
            $count = Pemesanan::where('status_pemesanan', 'Disetujui')->where('id_ruangan', $r->id_ruangan)->count();
            $pesananBerjalanStats[$r->nama_ruangan] = $count;
        }
        $countFasilitas = Pemesanan::where('status_pemesanan', 'Disetujui')->whereNull('id_ruangan')->count();
        if ($countFasilitas > 0) {
            $pesananBerjalanStats['Fasilitas'] = $countFasilitas;
        }

        // Calendar Events - Pemeliharaan
        $pemeliharaanEvents = Pemeliharaan::where('status_pemeliharaan', 'Berjalan')
            ->get()
            ->map(function ($p) {
                return [
                    'id' => 'pm_' . $p->id_pemeliharaan,
                    'title' => $p->nama_pemeliharaan,
                    'start' => $p->tglMulai_pemeliharaan,
                    'end' => date('Y-m-d', strtotime($p->tglSelesai_pemeliharaan . ' +1 day')),
                    'color' => '#612713',
                    'allDay' => true
                ];
            });

        // Calendar Events - Karyawan
        $jadwalKaryawans = \App\Models\JadwalKaryawan::with('user')->get();
        $karyawanEvents = collect();
        $daysMap = ['Minggu' => 0, 'Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6];
        foreach ($jadwalKaryawans as $jadwal) {
            $userTitle = $jadwal->user ? $jadwal->user->name : 'Tanpa Nama';
            $title = $jadwal->tugas . ' - ' . $userTitle;
            if ($jadwal->rutin) {
                $karyawanEvents->push([
                    'id' => 'jk_' . $jadwal->id_jadwal,
                    'title' => $title,
                    'daysOfWeek' => [$daysMap[ucfirst(strtolower($jadwal->rutin))] ?? 0],
                    'color' => '#994D1C',
                    'allDay' => true
                ]);
            } elseif ($jadwal->tanggal) {
                $karyawanEvents->push([
                    'id' => 'jk_' . $jadwal->id_jadwal,
                    'title' => $title,
                    'start' => $jadwal->tanggal,
                    'color' => '#612713',
                    'allDay' => true
                ]);
            }
        }

        // 3. Pesanan Selesai
        $pesananSelesaiCount = Pemesanan::where('status_pemesanan', 'Selesai')->count();

        // 4. Jenis Fasilitas
        $fasilitasNonElektronik = Fasilitas::whereIn('jenis_fasilitas', ['Umum', 'Ruangan'])->count();
        $fasilitasElektronik = Fasilitas::whereNotIn('jenis_fasilitas', ['Umum', 'Ruangan'])->count();
        $totalJenisFasilitas = $fasilitasNonElektronik + $fasilitasElektronik;

        // 5. Status Fasilitas
        $fasTersedia = Fasilitas::where('status_fasilitas', 'Tersedia')->count();
        $fasTerpakai = Fasilitas::where('status_fasilitas', 'Terpakai')->count();
        $fasPemeliharaan = Fasilitas::where('status_fasilitas', 'Pemeliharaan')->count();
        $totalStatusFasilitas = $fasTersedia + $fasTerpakai + $fasPemeliharaan;

        return view('admin.dashboard', compact(
            'events', 
            'pemeliharaanEvents',
            'karyawanEvents',
            'pesananBaruCount', 
            'pesananBerjalanCount', 
            'pesananBerjalanStats', 
            'pesananSelesaiCount', 
            'fasilitasNonElektronik', 
            'fasilitasElektronik', 
            'totalJenisFasilitas',
            'fasTersedia', 
            'fasTerpakai', 
            'fasPemeliharaan', 
            'totalStatusFasilitas'
        ));
    }

    public function home()
    {
        $ruangans = Ruangan::where('status_ruangan', 'Tersedia')->get();
        $fasilitas = Fasilitas::where('status_fasilitas', 'Tersedia')->get()->groupBy('jenis_fasilitas');

        $roomColors = [
            1 => '#F5CCA0',
            2 => '#994D1C',
            3 => '#6B240D',
        ];

        $events = Pemesanan::with('ruangan')
            ->whereNotIn('status_pemesanan', ['Dibatalkan', 'Ditolak', 'Selesai'])
            ->get()
            ->map(function ($booking) use ($roomColors) {
                $title = $booking->ruangan->nama_ruangan . ": Booked";

                $color = $roomColors[$booking->id_ruangan] ?? '#6B240D';

                return [
                    'title' => $title,
                    'start' => $booking->tgl_mulai,
                    'end' => date('Y-m-d', strtotime($booking->tgl_selesai . ' +1 day')),
                    'color' => $color,
                    'allDay' => true
                ];
            });

        return view('home', compact('ruangans', 'fasilitas', 'events'));
    }

    public function booking()
    {
        $ruangans = Ruangan::where('status_ruangan', 'Tersedia')->get();
        $fasilitas = Fasilitas::where('status_fasilitas', 'Tersedia')->get()->groupBy('jenis_fasilitas');

        $roomColors = [
            1 => '#F5CCA0',
            2 => '#994D1C',
            3 => '#6B240D',
        ];

        $events = Pemesanan::with('ruangan')
            ->whereNotIn('status_pemesanan', ['Dibatalkan', 'Ditolak', 'Selesai'])
            ->get()
            ->map(function ($booking) use ($roomColors) {
                $title = $booking->ruangan->nama_ruangan . ": Booked";

                $color = $roomColors[$booking->id_ruangan] ?? '#6B240D';

                return [
                    'title' => $title,
                    'start' => $booking->tgl_mulai,
                    'end' => date('Y-m-d', strtotime($booking->tgl_selesai . ' +1 day')),
                    'color' => $color,
                    'allDay' => true
                ];
            });

        return view('booking', compact('ruangans', 'fasilitas', 'events'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_pemesan' => 'required|string|max:255',
                'telp_pemesan' => 'required|string|max:15',
                'email_pemesan' => 'required|email|max:255',
                'nama_acara' => 'required|string|max:255',
                'alamat_pemesan' => 'required|string|max:255',
                'jumlah_orang' => 'required|integer',
                'tgl_mulai' => 'required|date',
                'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
                'id_ruangan' => 'nullable|integer',
                'keterangan_pemesanan' => 'nullable|string'
            ]);

            Log::info('Mencoba menambahkan data pemesanan baru: ' . $request->nama_pemesan);
            DB::beginTransaction();

            // 1. Pengecekan overlap untuk Ruangan
            if ($request->id_ruangan) {
                $isRoomBooked = Pemesanan::where('id_ruangan', $request->id_ruangan)
                    ->whereNotIn('status_pemesanan', ['Dibatalkan', 'Ditolak'])
                    ->where(function ($query) use ($request) {
                        $query->where('tgl_mulai', '<=', $request->tgl_selesai)
                            ->where('tgl_selesai', '>=', $request->tgl_mulai);
                    })->exists();

                if ($isRoomBooked) {
                    throw new Exception('Ruangan sudah dipesan pada tanggal tersebut.');
                }
            }

            // 2. Pengecekan overlap untuk Fasilitas
            if ($request->has('fasilitas')) {
                foreach ($request->fasilitas as $fasilitas_id) {
                    if (is_numeric($fasilitas_id)) {
                        $facility = Fasilitas::find($fasilitas_id);
                        if ($facility) {
                            $qty_input = $request->input('qty_fasilitas.' . $fasilitas_id);
                            $requested_qty = ($facility->jumlah_fasilitas > 1 && $qty_input !== null && (int) $qty_input > 0) ? (int) $qty_input : 1;

                            $used_qty = DetailFasilitas::where('id_fasilitas', $fasilitas_id)
                                ->whereHas('pemesanan', function ($query) use ($request) {
                                    $query->whereNotIn('status_pemesanan', ['Dibatalkan', 'Ditolak', 'Selesai'])
                                        ->where('tgl_mulai', '<=', $request->tgl_selesai)
                                        ->where('tgl_selesai', '>=', $request->tgl_mulai);
                                })->sum('jumlah_fasilitas');

                            $available_qty = $facility->jumlah_fasilitas - $used_qty;

                            if ($requested_qty > $available_qty) {
                                throw new Exception('Fasilitas ' . $facility->nama_fasilitas . ' tidak mencukupi. (Tersisa: ' . max(0, $available_qty) . ').');
                            }
                        }
                    }
                }
            }

            // 3. Simpan Data Pemesanan (Logika id_user digabung di sini)
            $pemesanan = Pemesanan::create([
                'no_nota' => 'INV-' . strtoupper(Str::random(8)),
                'nama_pemesan' => $request->nama_pemesan,
                'telp_pemesan' => $request->telp_pemesan,
                'email_pemesan' => $request->email_pemesan,
                'alamat_pemesan' => $request->alamat_pemesan,
                'nama_acara' => $request->nama_acara,
                'jumlah_orang' => $request->jumlah_orang,
                'tgl_pesan' => now()->toDateString(),
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'status_pemesanan' => 'Menunggu',
                'keterangan_pemesanan' => $request->keterangan_pemesanan,
                'id_ruangan' => $request->id_ruangan,
                'id_user' => auth()->check() ? auth()->id() : null, // Cek jika login pakai ID, jika tidak null
            ]);

            // 4. Simpan Detail Fasilitas
            if ($request->has('fasilitas')) {
                foreach ($request->fasilitas as $fasilitas_id) {
                    if (is_numeric($fasilitas_id)) {
                        $facility = Fasilitas::find($fasilitas_id);
                        if ($facility) {
                            $qty_input = $request->input('qty_fasilitas.' . $fasilitas_id);
                            $requested_qty = ($facility->jumlah_fasilitas > 1 && $qty_input !== null && (int) $qty_input > 0) ? (int) $qty_input : 1;

                            DetailFasilitas::create([
                                'id_pemesanan' => $pemesanan->id_pemesanan,
                                'id_fasilitas' => $fasilitas_id,
                                'jumlah_fasilitas' => $requested_qty
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            try {
                $admins = User::where('role', 'Admin')->get();
                foreach ($admins as $admin) {
                    Mail::to($admin->email)->send(new AdminNotificationMail($pemesanan, 'baru'));
                }
            } catch (Exception $e) {
                Log::error('Gagal mengirim email notifikasi admin: ' . $e->getMessage());
            }

            return redirect()->back()->with('success', 'Booking berhasil dikirim! Nota: ' . $pemesanan->no_nota);

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $pemesanan = Pemesanan::findOrFail($id);
            $action = $request->input('action');

            if ($action === 'setuju') {
                $pemesanan->status_pemesanan = 'Disetujui';
            } elseif ($action === 'tolak') {
                $pemesanan->status_pemesanan = 'Ditolak';
            } elseif ($action === 'selesai') {
                $pemesanan->status_pemesanan = 'Selesai';
            }

            $pemesanan->save();

            if (in_array($action, ['setuju', 'tolak'])) {
                try {
                    $pemesanan->load(['ruangan', 'detailF.fasilitas']);
                    $statusMap = ['setuju' => 'Disetujui', 'tolak' => 'Ditolak'];
                    $statusText = $statusMap[$action];
                    Mail::to($pemesanan->email_pemesan)->send(new CustomerStatusMail($pemesanan, $statusText));
                } catch (Exception $e) {
                    Log::error('Gagal mengirim email notifikasi customer: ' . $e->getMessage());
                }
            }

            return redirect()->back()->with('success', 'Status pemesanan berhasil diperbarui!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $pemesanan = Pemesanan::findOrFail($id);
            
            $request->validate([
                'nama_pemesan' => 'required|string|max:255',
                'telp_pemesan' => 'required|string|max:15',
                'email_pemesan' => 'required|email|max:255',
                'nama_acara' => 'required|string|max:255',
                'alamat_pemesan' => 'required|string|max:255',
                'jumlah_orang' => 'required|integer',
                'tgl_mulai' => 'required|date',
                'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
                'id_ruangan' => 'nullable|integer',
                'keterangan_pemesanan' => 'nullable|string'
            ]);

            DB::beginTransaction();

            // 1. Pengecekan overlap untuk Ruangan (Kecuali ID sendiri)
            if ($request->id_ruangan) {
                $isRoomBooked = Pemesanan::where('id_ruangan', $request->id_ruangan)
                    ->where('id_pemesanan', '!=', $id)
                    ->whereNotIn('status_pemesanan', ['Dibatalkan', 'Ditolak', 'Selesai'])
                    ->where(function ($query) use ($request) {
                        $query->where('tgl_mulai', '<=', $request->tgl_selesai)
                            ->where('tgl_selesai', '>=', $request->tgl_mulai);
                    })->exists();

                if ($isRoomBooked) {
                    throw new Exception('Ruangan sudah dipesan pada tanggal tersebut.');
                }
            }

            // 2. Pengecekan overlap untuk Fasilitas (Kecuali ID sendiri)
            if ($request->has('fasilitas')) {
                foreach ($request->fasilitas as $fasilitas_id) {
                    if (is_numeric($fasilitas_id)) {
                        $facility = Fasilitas::find($fasilitas_id);
                        if ($facility) {
                            $qty_input = $request->input('qty_fasilitas.' . $fasilitas_id);
                            $requested_qty = ($facility->jumlah_fasilitas > 1 && $qty_input !== null && (int) $qty_input > 0) ? (int) $qty_input : 1;

                            $used_qty = DetailFasilitas::where('id_fasilitas', $fasilitas_id)
                                ->whereHas('pemesanan', function ($query) use ($request, $id) {
                                    $query->where('id_pemesanan', '!=', $id)
                                        ->whereNotIn('status_pemesanan', ['Dibatalkan', 'Ditolak', 'Selesai'])
                                        ->where('tgl_mulai', '<=', $request->tgl_selesai)
                                        ->where('tgl_selesai', '>=', $request->tgl_mulai);
                                })->sum('jumlah_fasilitas');

                            $available_qty = $facility->jumlah_fasilitas - $used_qty;

                            if ($requested_qty > $available_qty) {
                                throw new Exception('Fasilitas ' . $facility->nama_fasilitas . ' tidak mencukupi. (Tersedia: ' . max(0, $available_qty) . ').');
                            }
                        }
                    }
                }
            }

            // 3. Update Data Pemesanan
            $pemesanan->update([
                'nama_pemesan' => $request->nama_pemesan,
                'telp_pemesan' => $request->telp_pemesan,
                'email_pemesan' => $request->email_pemesan,
                'alamat_pemesan' => $request->alamat_pemesan,
                'nama_acara' => $request->nama_acara,
                'jumlah_orang' => $request->jumlah_orang,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'keterangan_pemesanan' => $request->keterangan_pemesanan,
                'id_ruangan' => $request->id_ruangan,
            ]);

            // 4. Update Detail Fasilitas (Delete insert)
            DetailFasilitas::where('id_pemesanan', $id)->delete();

            if ($request->has('fasilitas')) {
                foreach ($request->fasilitas as $fasilitas_id) {
                    if (is_numeric($fasilitas_id)) {
                        $facility = Fasilitas::find($fasilitas_id);
                        if ($facility) {
                            $qty_input = $request->input('qty_fasilitas.' . $fasilitas_id);
                            $requested_qty = ($facility->jumlah_fasilitas > 1 && $qty_input !== null && (int) $qty_input > 0) ? (int) $qty_input : 1;

                            DetailFasilitas::create([
                                'id_pemesanan' => $pemesanan->id_pemesanan,
                                'id_fasilitas' => $fasilitas_id,
                                'jumlah_fasilitas' => $requested_qty
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Data pemesanan berhasil diperbarui!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function history(Request $request)
    {
        $query = Pemesanan::with(['ruangan', 'detailF.fasilitas'])
            ->where(function ($q) {
                $q->where('id_user', auth()->id())
                    ->orWhere('email_pemesan', auth()->user()->email);
            });

        $activeTab = $request->input('tab', 'semua');

        if ($activeTab == 'menunggu') {
            $query->whereIn('status_pemesanan', ['Menunggu']);
        } elseif ($activeTab == 'disetujui') {
            $query->where('status_pemesanan', 'Disetujui');
        } elseif ($activeTab == 'selesai') {
            $query->where('status_pemesanan', 'Selesai');
        } elseif ($activeTab == 'dibatalkan') {
            $query->whereIn('status_pemesanan', ['Dibatalkan', 'Ditolak']);
        }

        $histories = $query->orderBy('updated_at', 'desc')->get();
        return view('history', compact('histories', 'activeTab'));
    }

    public function batal($id)
    {
        try {
            $pemesanan = Pemesanan::where('id_pemesanan', $id)
                ->where(function ($q) {
                    $q->where('id_user', auth()->id())
                        ->orWhere('email_pemesan', auth()->user()->email);
                })->firstOrFail();

            if (strtolower($pemesanan->status_pemesanan) === 'menunggu') {
                $pemesanan->status_pemesanan = 'Dibatalkan';
                $pemesanan->save();

                try {
                    $admins = \App\Models\User::where('role', 'Admin')->get();
                    foreach ($admins as $admin) {
                        Mail::to($admin->email)->send(new AdminNotificationMail($pemesanan, 'batal'));
                    }
                } catch (Exception $e) {
                    Log::error('Gagal mengirim email notifikasi admin (batal): ' . $e->getMessage());
                }

                return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
            }

            return redirect()->back()->with('error', 'Status pesanan tidak dapat dibatalkan.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cetakNota($id)
    {
        $pemesanan = Pemesanan::with(['ruangan', 'detailF.fasilitas'])
            ->where('id_pemesanan', $id)
            ->where(function ($q) {
                $q->where('id_user', auth()->id())
                    ->orWhere('email_pemesan', auth()->user()->email);
            })->firstOrFail();

        $pdf = Pdf::loadView('pdf.nota', compact('pemesanan'));
        return $pdf->stream('Nota_' . $pemesanan->no_nota . '.pdf');
    }
}
