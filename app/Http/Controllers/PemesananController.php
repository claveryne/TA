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
use Carbon\Carbon;

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
            $query->where(['status_pemesanan' => 'Menunggu']);
        } elseif ($activeTab == 'disetujui') {
            $query->where(['status_pemesanan' => 'Disetujui']);
        } elseif ($activeTab == 'selesai') {
            $query->where(['status_pemesanan' => 'Selesai']);
        } elseif ($activeTab == 'dibatalkan') {
            $query->whereIn('status_pemesanan', ['Dibatalkan', 'Ditolak']);
        }

        $pemesanans = $query->orderByRaw('updated_at DESC')->get();
        $ruangans = Ruangan::where(['status_ruangan' => 'Tersedia'])->get();
        $fasilitases = Fasilitas::where(['status_fasilitas' => 'Tersedia'])->get()->groupBy(fn($f) => $f->jenis_fasilitas);
        return view('admin.pemesanan', compact('pemesanans', 'activeTab', 'ruangans', 'fasilitases'));
    }

    public function dashboard()
    {
        $events = $this->getBookingEvents();
        $pesananBaruCount = Pemesanan::where(['status_pemesanan' => 'Menunggu'])->count();
        $pesananBerjalanCount = Pemesanan::where(['status_pemesanan' => 'Disetujui'])->count();
        $pesananBerjalanStats = $this->getPesananBerjalanStats();
        $pemeliharaanEvents = $this->getPemeliharaanEvents();
        $karyawanEvents = $this->getKaryawanEvents();
        $pesananSelesaiCount = Pemesanan::where(['status_pemesanan' => 'Selesai'])->count();

        $fasilitasStats = $this->getFasilitasStats();

        return view('admin.dashboard', array_merge([
            'events' => $events,
            'pemeliharaanEvents' => $pemeliharaanEvents,
            'karyawanEvents' => $karyawanEvents,
            'pesananBaruCount' => $pesananBaruCount,
            'pesananBerjalanCount' => $pesananBerjalanCount,
            'pesananBerjalanStats' => $pesananBerjalanStats,
            'pesananSelesaiCount' => $pesananSelesaiCount,
        ], $fasilitasStats));
    }

    private function getBookingEvents()
    {
        $roomColors = [
            1 => '#F5CCA0',
            2 => '#994D1C',
            3 => '#6B240D',
        ];

        return Pemesanan::with('ruangan')
            ->whereNotIn('status_pemesanan', ['Dibatalkan', 'Ditolak', 'Selesai'])
            ->get()
            ->map(function ($booking) use ($roomColors) {
                $title = $booking->ruangan ? $booking->ruangan->nama_ruangan . ": Booked" : "Fasilitas: Booked";
                $color = $roomColors[$booking->id_ruangan] ?? '#6B240D';

                return [
                    'title' => $title,
                    'start' => $booking->tgl_mulai,
                    'end' => $booking->tgl_selesai,
                    'color' => $color,
                    'allDay' => false
                ];
            });
    }

    private function getPesananBerjalanStats()
    {
        $ruangansList = Ruangan::orderByRaw('id_ruangan ASC')->get();
        $pesananBerjalanStats = collect();
        foreach ($ruangansList as $r) {
            $count = Pemesanan::where(['status_pemesanan' => 'Disetujui'])->where(['id_ruangan' => $r->id_ruangan])->count();
            $pesananBerjalanStats[$r->nama_ruangan] = $count;
        }
        $countFasilitas = Pemesanan::where(['status_pemesanan' => 'Disetujui'])->whereNull('id_ruangan')->count();
        if ($countFasilitas > 0) {
            $pesananBerjalanStats['Fasilitas'] = $countFasilitas;
        }

        return $pesananBerjalanStats;
    }

    private function getPemeliharaanEvents()
    {
        return Pemeliharaan::where(['status_pemeliharaan' => 'Berjalan'])
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
    }

    private function getKaryawanEvents()
    {
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

        return $karyawanEvents;
    }

    private function getFasilitasStats()
    {
        $fasilitasNonElektronik = Fasilitas::whereIn('jenis_fasilitas', ['Umum', 'Ruangan'])->sum('jumlah_fasilitas');
        $fasilitasElektronik = Fasilitas::whereNotIn('jenis_fasilitas', ['Umum', 'Ruangan'])->sum('jumlah_fasilitas');
        $totalJenisFasilitas = $fasilitasNonElektronik + $fasilitasElektronik;

        $totalFasilitas = Fasilitas::sum('jumlah_fasilitas');

        $fasPemeliharaan = Pemeliharaan::where(['status_pemeliharaan' => 'Berjalan'])->get()->map(function ($p) {
            return max(1, (int) $p->jumlah_pemeliharaan);
        })->sum();

        $fasTerpakai = DetailFasilitas::whereHas('pemesanan', function ($query) {
            $query->whereNotIn('status_pemesanan', ['Dibatalkan', 'Ditolak', 'Selesai'])
                ->where([
                    ['tgl_mulai', '<=', now()],
                    ['tgl_selesai', '>=', now()]
                ]);
        })->sum('jumlah_fasilitas');

        $ruanganTerpakai = Pemesanan::whereNotNull('id_ruangan')
            ->whereNotIn('status_pemesanan', ['Dibatalkan', 'Ditolak', 'Selesai'])
            ->where([
                ['tgl_mulai', '<=', now()],
                ['tgl_selesai', '>=', now()]
            ])
            ->count();

        $fasTerpakai += $ruanganTerpakai;

        $fasTersedia = max(0, $totalFasilitas - $fasPemeliharaan - $fasTerpakai);

        $totalStatusFasilitas = $fasTersedia + $fasTerpakai + $fasPemeliharaan;

        return [
            'fasilitasNonElektronik' => $fasilitasNonElektronik,
            'fasilitasElektronik' => $fasilitasElektronik,
            'totalJenisFasilitas' => $totalJenisFasilitas,
            'fasTersedia' => $fasTersedia,
            'fasTerpakai' => $fasTerpakai,
            'fasPemeliharaan' => $fasPemeliharaan,
            'totalStatusFasilitas' => $totalStatusFasilitas,
        ];
    }

    private function getAvailableFasilitas()
    {
        return Fasilitas::where(['status_fasilitas' => 'Tersedia'])->get()->map(function ($f) {
            $activePemeliharaan = Pemeliharaan::where([
                ['nama_pemeliharaan', 'Fasilitas - ' . $f->nama_fasilitas],
                ['status_pemeliharaan', 'Berjalan']
            ])->sum('jumlah_pemeliharaan');
            $f->jumlah_fasilitas -= $activePemeliharaan;
            return $f;
        })->filter(function ($f) {
            return $f->jumlah_fasilitas > 0;
        })->groupBy(fn($f) => $f->jenis_fasilitas);
    }

    public function home()
    {
        $ruangans = Ruangan::where(['status_ruangan' => 'Tersedia'])->get();
        $fasilitas = $this->getAvailableFasilitas();
        $events = $this->getBookingEvents();

        return view('home', compact('ruangans', 'fasilitas', 'events'));
    }

    public function booking()
    {
        $ruangans = Ruangan::where(['status_ruangan' => 'Tersedia'])->get();
        $fasilitas = $this->getAvailableFasilitas();
        $events = $this->getBookingEvents();

        return view('booking', compact('ruangans', 'fasilitas', 'events'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_pemesan' => 'required|string|max:255',
                'telp_pemesan' => 'required|numeric|digits_between:10,15',
                'email_pemesan' => 'required|email|max:255',
                'nama_acara' => 'required|string|max:255',
                'alamat_pemesan' => 'required|string|max:255',
                'jumlah_orang' => 'required|integer',
                'tgl_mulai' => 'required|date',
                'tgl_selesai' => 'required|date|after:tgl_mulai',
                'id_ruangan' => 'nullable|integer',
                'keterangan_pemesanan' => 'nullable|string'
            ]);

            $mulai = Carbon::parse($request->tgl_mulai);
            $selesai = Carbon::parse($request->tgl_selesai);

            if ($mulai->lt(now()->subMinutes(5))) {
                throw new Exception('Waktu mulai tidak boleh kurang dari waktu sekarang.');
            }
            if ($selesai->lte($mulai)) {
                throw new Exception('Waktu selesai harus lebih dari waktu mulai.');
            }
            if ($mulai->diffInMinutes($selesai) < 60) {
                throw new Exception('Durasi pemesanan minimal 1 jam.');
            }

            Log::info('Mencoba menambahkan data pemesanan baru: ' . $request->nama_pemesan);
            DB::beginTransaction();

            // Cek bentrok menggunakan helper method
            $this->checkBookingConflicts($request);

            $pemesanan = Pemesanan::create([
                'no_nota' => 'INV-' . strtoupper(Str::random(8)),
                'nama_pemesan' => $request->nama_pemesan,
                'telp_pemesan' => $request->telp_pemesan,
                'email_pemesan' => $request->email_pemesan,
                'alamat_pemesan' => $request->alamat_pemesan,
                'nama_acara' => $request->nama_acara,
                'jumlah_orang' => $request->jumlah_orang,
                'tgl_pesan' => now(),
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'status_pemesanan' => 'Menunggu',
                'keterangan_pemesanan' => $request->keterangan_pemesanan,
                'id_ruangan' => $request->id_ruangan,
                'id_user' => auth()->check() ? auth()->id() : null,
            ]);

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
                $admins = User::where(['role' => 'Admin'])->get();
                foreach ($admins as $admin) {
                    Mail::to($admin->email)->send(new AdminNotificationMail($pemesanan, 'baru'));
                }
            } catch (Exception $e) {
                Log::error('Gagal mengirim email notifikasi admin: ' . $e->getMessage());
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Booking berhasil dikirim! Nota: ' . $pemesanan->no_nota
                ]);
            }

            return redirect()->back()->with('success', 'Booking berhasil dikirim! Nota: ' . $pemesanan->no_nota);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->validator->errors()->all(),
                    'message' => 'Terjadi kesalahan validasi.'
                ], 422);
            }
            return redirect()->back()->withInput()->withErrors($e->errors())->with('error', 'Terjadi kesalahan validasi: ' . implode(', ', $e->validator->errors()->all()));
        } catch (Exception $e) {
            DB::rollBack();
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
            } elseif ($action === 'batal') {
                $pemesanan->status_pemesanan = 'Dibatalkan';
            }

            $pemesanan->save();

            if (in_array($action, ['setuju', 'tolak', 'batal'])) {
                try {
                    $pemesanan->load(['ruangan', 'detailF.fasilitas']);
                    $statusMap = ['setuju' => 'Disetujui', 'tolak' => 'Ditolak', 'batal' => 'Dibatalkan'];
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

    public function destroy($id)
    {
        try {
            $pemesanan = Pemesanan::findOrFail($id);
            $pemesanan->status_pemesanan = 'Ditolak';
            $pemesanan->save();

            return redirect()->back()->with('success', 'Pemesanan berhasil ditolak / dihapus.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function checkBookingConflicts(Request $request, $ignorePemesananId = null)
    {
        // cek bentrok ruangan
        if ($request->id_ruangan) {
            // ruangan yang sama tidak bisa dipilih sebagai fasilitas tambahan
            if ($request->has('fasilitas')) {
                $room = Ruangan::find($request->id_ruangan);
                if ($room) {
                    $corresponding_facility = Fasilitas::where([
                        ['nama_fasilitas', $room->nama_ruangan],
                        ['jenis_fasilitas', 'Ruangan']
                    ])->first();
                    if ($corresponding_facility && in_array($corresponding_facility->id_fasilitas, $request->fasilitas)) {
                        throw new Exception('Ruangan ' . $room->nama_ruangan . ' tidak dapat dipilih sebagai fasilitas tambahan karena sudah menjadi ruangan utama.');
                    }
                }
            }

            $isRoomBookedQuery = Pemesanan::where(['id_ruangan' => $request->id_ruangan])
                ->whereNotIn('status_pemesanan', ['Dibatalkan', 'Ditolak', 'Selesai'])
                ->where(function ($query) use ($request) {
                    $query->where([
                        ['tgl_mulai', '<', $request->tgl_selesai],
                        ['tgl_selesai', '>', $request->tgl_mulai]
                    ]);
                });

            if ($ignorePemesananId) {
                $isRoomBookedQuery->where('id_pemesanan', '!=', $ignorePemesananId);
            }

            if ($isRoomBookedQuery->exists()) {
                throw new Exception('Ruangan sudah dipesan pada waktu tersebut.');
            }

            // cek ruangan sedang dipesan sebagai fasilitas di pemesanan lain atau tidak
            $room = Ruangan::find($request->id_ruangan);
            if ($room) {
                $corresponding_facility = Fasilitas::where([
                    ['nama_fasilitas', $room->nama_ruangan],
                    ['jenis_fasilitas', 'Ruangan']
                ])->first();
                if ($corresponding_facility) {
                    $isFacilityBookedQuery = DetailFasilitas::where(['id_fasilitas' => $corresponding_facility->id_fasilitas])
                        ->whereHas('pemesanan', function ($query) use ($request, $ignorePemesananId) {
                            $query->whereNotIn('status_pemesanan', ['Dibatalkan', 'Ditolak', 'Selesai'])
                                ->where([
                                    ['tgl_mulai', '<', $request->tgl_selesai],
                                    ['tgl_selesai', '>', $request->tgl_mulai]
                                ]);
                            if ($ignorePemesananId) {
                                $query->where('id_pemesanan', '!=', $ignorePemesananId);
                            }
                        });

                    if ($ignorePemesananId) {
                        $isFacilityBookedQuery->where('id_pemesanan', '!=', $ignorePemesananId);
                    }

                    if ($isFacilityBookedQuery->exists()) {
                        throw new Exception('Ruangan ' . $room->nama_ruangan . ' sedang dipesan sebagai fasilitas tambahan pada waktu tersebut.');
                    }
                }
            }
        }

        // cek bentrok fasilitas
        if ($request->has('fasilitas')) {
            foreach ($request->fasilitas as $fasilitas_id) {
                if (is_numeric($fasilitas_id)) {
                    $facility = Fasilitas::find($fasilitas_id);
                    if ($facility) {
                        $qty_input = $request->input('qty_fasilitas.' . $fasilitas_id);
                        $requested_qty = ($facility->jumlah_fasilitas > 1 && $qty_input !== null && (int) $qty_input > 0) ? (int) $qty_input : 1;

                        $used_qty = DetailFasilitas::where(['id_fasilitas' => $fasilitas_id])
                            ->whereHas('pemesanan', function ($query) use ($request, $ignorePemesananId) {
                                $query->whereNotIn('status_pemesanan', ['Dibatalkan', 'Ditolak', 'Selesai'])
                                    ->where([
                                        ['tgl_mulai', '<', $request->tgl_selesai],
                                        ['tgl_selesai', '>', $request->tgl_mulai]
                                    ]);
                                if ($ignorePemesananId) {
                                    $query->where('id_pemesanan', '!=', $ignorePemesananId);
                                }
                            })->sum('jumlah_fasilitas');

                        // cek fasilitas ruangan tidak sedang dibooking
                        if ($facility->jenis_fasilitas === 'Ruangan') {
                            $corresponding_room = Ruangan::where(['nama_ruangan' => $facility->nama_fasilitas])->first();
                            if ($corresponding_room) {
                                $isRoomBookedDirectlyQuery = Pemesanan::where(['id_ruangan' => $corresponding_room->id_ruangan])
                                    ->whereNotIn('status_pemesanan', ['Dibatalkan', 'Ditolak', 'Selesai'])
                                    ->where(function ($query) use ($request) {
                                        $query->where([
                                            ['tgl_mulai', '<', $request->tgl_selesai],
                                            ['tgl_selesai', '>', $request->tgl_mulai]
                                        ]);
                                    });

                                if ($ignorePemesananId) {
                                    $isRoomBookedDirectlyQuery->where('id_pemesanan', '!=', $ignorePemesananId);
                                }

                                if ($isRoomBookedDirectlyQuery->exists()) {
                                    $used_qty += 1;
                                }
                            }
                        }

                        $active_maintenance = Pemeliharaan::where([
                            ['nama_pemeliharaan', 'Fasilitas - ' . $facility->nama_fasilitas],
                            ['status_pemeliharaan', 'Berjalan']
                        ])->sum('jumlah_pemeliharaan');

                        $available_qty = $facility->jumlah_fasilitas - $used_qty - $active_maintenance;

                        if ($requested_qty > $available_qty) {
                            throw new Exception('Fasilitas ' . $facility->nama_fasilitas . 
                                ' tidak mencukupi. (Tersedia: ' . max(0, $available_qty) . ').');
                        }
                    }
                }
            }
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $pemesanan = Pemesanan::findOrFail($id);

            $request->validate([
                'nama_pemesan' => 'required|string|max:255',
                'telp_pemesan' => 'required|numeric|digits_between:10,15',
                'email_pemesan' => 'required|email|max:255',
                'nama_acara' => 'required|string|max:255',
                'alamat_pemesan' => 'required|string|max:255',
                'jumlah_orang' => 'required|integer',
                'tgl_mulai' => 'required|date',
                'tgl_selesai' => 'required|date|after:tgl_mulai',
                'id_ruangan' => 'nullable|integer',
                'keterangan_pemesanan' => 'nullable|string',
                'bukti_pemesanan' => 'nullable|image|mimes:jpg,jpeg,png|max:10240'
            ]);

            $mulai = Carbon::parse($request->tgl_mulai);
            $selesai = Carbon::parse($request->tgl_selesai);

            $oldMulai = Carbon::parse($pemesanan->tgl_mulai);
            if (!$oldMulai->eq($mulai) && $mulai->lt(now()->subMinutes(5))) {
                throw new Exception('Waktu mulai tidak boleh kurang dari waktu sekarang.');
            }
            if ($selesai->lte($mulai)) {
                throw new Exception('Waktu selesai harus lebih dari waktu mulai.');
            }
            if ($mulai->diffInMinutes($selesai) < 60) {
                throw new Exception('Durasi pemesanan minimal 1 jam.');
            }

            DB::beginTransaction();

            // Cek bentrok menggunakan helper method
            $this->checkBookingConflicts($request, $id);

            $fileName = $pemesanan->bukti_pemesanan;
            if ($request->hasFile('bukti_pemesanan')) {
                $file = $request->file('bukti_pemesanan');
                $fileName = 'bukti_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/bukti'), $fileName);
            }

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
                'bukti_pemesanan' => $fileName,
            ]);

            DetailFasilitas::query()->where(['id_pemesanan' => $id])->delete();

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
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->errors())->with('error', 'Terjadi kesalahan validasi: ' . implode(', ', $e->validator->errors()->all()))->with('failed_booking_id', $id);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->with('failed_booking_id', $id);
        }
    }

    public function history(Request $request)
    {
        $query = Pemesanan::with(['ruangan', 'detailF.fasilitas'])
            ->where(function ($q) {
                $q->where(['id_user' => auth()->id()])
                    ->orWhere(['email_pemesan' => auth()->user()->email]);
            });

        $activeTab = $request->input('tab', 'semua');

        if ($activeTab == 'menunggu') {
            $query->whereIn('status_pemesanan', ['Menunggu']);
        } elseif ($activeTab == 'disetujui') {
            $query->where(['status_pemesanan' => 'Disetujui']);
        } elseif ($activeTab == 'selesai') {
            $query->where(['status_pemesanan' => 'Selesai']);
        } elseif ($activeTab == 'dibatalkan') {
            $query->whereIn('status_pemesanan', ['Dibatalkan', 'Ditolak']);
        }

        $histories = $query->orderByRaw('updated_at desc')->get();
        return view('history', compact('histories', 'activeTab'));
    }

    public function batal($id)
    {
        try {
            $pemesanan = Pemesanan::where(['id_pemesanan' => $id])
                ->where(function ($q) {
                    $q->where(['id_user' => auth()->id()])
                        ->orWhere(['email_pemesan' => auth()->user()->email]);
                })->firstOrFail();

            if (strtolower($pemesanan->status_pemesanan) === 'menunggu') {
                $pemesanan->status_pemesanan = 'Dibatalkan';
                $pemesanan->save();

                try {
                    $admins = User::where(['role' => 'Admin'])->get();
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
            ->where(['id_pemesanan' => $id])
            ->where(function ($q) {
                $q->where(['id_user' => auth()->id()])
                    ->orWhere(['email_pemesan' => auth()->user()->email]);
            })->firstOrFail();

        $pdf = Pdf::loadView('pdf.nota', compact('pemesanan'));
        return $pdf->stream('Nota_' . $pemesanan->no_nota . '.pdf');
    }

    public function cetakLaporan(Request $request)
    {
        $request->validate([
            'bulan' => 'required',
            'tahun' => 'required',
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $pemesanan = Pemesanan::with(['ruangan', 'detailF.fasilitas'])
            ->whereMonth('tgl_mulai', $bulan)
            ->whereYear('tgl_mulai', $tahun)
            ->whereIn('status_pemesanan', ['Disetujui', 'Ditolak', 'Dibatalkan', 'Selesai'])
            ->get();

        $mahacitta = $pemesanan->filter(function ($item) {
            return $item->ruangan && stripos($item->ruangan->nama_ruangan, 'Mahacitta') !== false;
        });

        $vyria = $pemesanan->filter(function ($item) {
            return $item->ruangan && stripos($item->ruangan->nama_ruangan, 'Vyria') !== false;
        });

        $villasita = $pemesanan->filter(function ($item) {
            return $item->ruangan && stripos($item->ruangan->nama_ruangan, 'Villasita') !== false;
        });

        $bulanNama = Carbon::create()->month((int) $bulan)->translatedFormat('F');

        $pdf = Pdf::loadView('pdf.pemesanan', compact('mahacitta', 'vyria', 'villasita', 'bulanNama', 'tahun'));
        return $pdf->stream('Laporan_Pemesanan_' . $bulanNama . '_' . $tahun . '.pdf');
    }
}
