<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\User;
use App\Models\JadwalKaryawan;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|max:255',
                'phone' => 'required|numeric|digits_between:10,15',
                'address' => 'required|max:255',
                'avatar' => 'nullable|image|mimes:jpg,png,jpeg|max:30720',
            ]);

            $user = auth()->user();
            Log::info('Mencoba mengupdate profile: ' . $user->name);

            $fileName = $user->avatar;
            if ($request->hasFile('avatar')) {
                if ($user->avatar && file_exists(public_path('uploads/user/' . $user->avatar))) {
                    @unlink(public_path('uploads/user/' . $user->avatar));
                }

                $file = $request->file('avatar');
                $fileName = 'user_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/user'), $fileName);
            }

            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'avatar' => $fileName,
            ]);

            Log::info('Profile pengguna berhasil diupdate.', [
                'id' => $user->id,
            ]);

            return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->with('error', 'Terjadi kesalahan validasi: ' . implode(', ', $e->validator->errors()->all()))
                ->withInput();
        } catch (Exception $e) {
            Log::error('GAGAL mengupdate profile.', [
                'error_message' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function storeKaryawan(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users,email|max:255',
                'phone' => 'required|numeric|digits_between:10,15',
                'address' => 'required|max:255',
                'avatar' => 'nullable|image|mimes:jpg,png,jpeg|max:30720',
                'role' => 'required|max:10',
                'status' => 'required|max:20',
                'password' => 'nullable|min:8|confirmed',
            ]);

            Log::info('Mencoba menambahkan data karyawan baru: ' . $request->name);

            $fileName = null;
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $fileName = 'user_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/user'), $fileName);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'avatar' => $fileName,
                'role' => $request->role,
                'status' => $request->status,
                'password' => $request->password ? bcrypt($request->password) : null,
            ]);

            Log::info('Data karyawan berhasil ditambahkan.', [
                'id' => $user->id,
                'name' => $user->name,
            ]);

            return redirect()->back()->with('success', 'Data karyawan berhasil ditambahkan!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->with('error', 'Terjadi kesalahan validasi: ' . implode(', ', $e->validator->errors()->all()))
                ->withInput();
        } catch (Exception $e) {
            Log::error('GAGAL menambahkan data karyawan.', [
                'error_message' => $e->getMessage(),
                'user_input' => $request->except('avatar'),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function indexKaryawan(Request $request)
    {
        $search = $request->input('search');

        $karyawan = User::query()->where(['status' => 'Aktif'])
            ->whereNotNull('role')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%");
                });
            })->get();

        $jadwals = JadwalKaryawan::with('user')->get();

        return view('admin.karyawan', compact('karyawan', 'search', 'jadwals'));
    }

    public function updateKaryawan(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $id,
                'phone' => 'required|numeric|digits_between:10,15',
                'address' => 'required|max:255',
                'avatar' => 'nullable|image|mimes:jpg,png,jpeg|max:30720',
                'role' => 'nullable|max:10',
                'status' => 'required|max:20',
                'password' => 'nullable|min:8|confirmed',
            ]);

            Log::info('Mencoba mengupdate data karyawan: ' . $request->name);

            $userOld = User::find($id);

            $fileName = $userOld->avatar;
            if ($request->hasFile('avatar')) {
                if ($userOld->avatar && file_exists(public_path('uploads/user/' . $userOld->avatar))) {
                    @unlink(public_path('uploads/user/' . $userOld->avatar));
                }

                $file = $request->file('avatar');
                $fileName = 'user_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/user'), $fileName);
            }

            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'avatar' => $fileName,
                'role' => $request->role,
                'status' => $request->status,
            ];

            if ($request->password) {
                $updateData['password'] = bcrypt($request->password);
            }

            $userOld->update($updateData);

            Log::info('Data karyawan berhasil diupdate.', [
                'id' => $id,
                'name' => $request->name,
            ]);

            return redirect()->back()->with('success', 'Data karyawan berhasil diupdate!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->with('error', 'Terjadi kesalahan validasi: ' . implode(', ', $e->validator->errors()->all()))
                ->withInput();
        } catch (Exception $e) {
            Log::error('GAGAL mengupdate data karyawan.', [
                'error_message' => $e->getMessage(),
                'user_input' => $request->except('avatar'),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function storeJadwal(Request $request)
    {
        try {
            $request->validate([
                'id_user' => 'required|exists:users,id',
                'tipe_jadwal' => 'required|in:rutin,tanggal',
                'tugas' => 'required|string|max:255',
            ]);

            $data = [
                'id_user' => $request->id_user,
                'tugas' => $request->tugas,
            ];

            if ($request->tipe_jadwal === 'rutin') {
                $request->validate(['rutin' => 'required|string']);
                $data['rutin'] = $request->rutin;
                $data['tanggal'] = null;
            } else {
                $request->validate(['tanggal' => 'required|date']);
                $data['tanggal'] = $request->tanggal;
                $data['rutin'] = null;
            }

            JadwalKaryawan::create($data);

            return redirect()->back()->with('success', 'Jadwal karyawan berhasil ditambahkan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->with('error', 'Terjadi kesalahan validasi: ' . implode(', ', $e->validator->errors()->all()))
                ->withInput();
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function updateJadwal(Request $request, $id)
    {
        try {
            $request->validate([
                'id_user' => 'required|exists:users,id',
                'tipe_jadwal' => 'required|in:rutin,tanggal',
                'tugas' => 'required|string|max:255',
            ]);

            $data = [
                'id_user' => $request->id_user,
                'tugas' => $request->tugas,
            ];

            if ($request->tipe_jadwal === 'rutin') {
                $request->validate(['rutin' => 'required|string']);
                $data['rutin'] = $request->rutin;
                $data['tanggal'] = null;
            } else {
                $request->validate(['tanggal' => 'required|date']);
                $data['tanggal'] = $request->tanggal;
                $data['rutin'] = null;
            }

            JadwalKaryawan::query()->where(['id_jadwal' => $id])->update($data);

            return redirect()->back()->with('success', 'Jadwal karyawan berhasil diupdate!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->with('error', 'Terjadi kesalahan validasi: ' . implode(', ', $e->validator->errors()->all()))
                ->withInput();
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function deleteJadwal($id)
    {
        try {
            JadwalKaryawan::query()->where(['id_jadwal' => $id])->delete();
            return redirect()->back()->with('success', 'Jadwal karyawan berhasil dihapus!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function storePelanggan(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users,email|max:255',
                'phone' => 'required|numeric|digits_between:10,15',
                'address' => 'required|max:255',
                'avatar' => 'nullable|image|mimes:jpg,png,jpeg|max:30720',
                'role' => 'nullable|max:10',
                'status' => 'nullable|max:20',
                'password' => 'nullable|min:8|confirmed',
            ]);

            Log::info('Mencoba menambahkan data pelanggan baru: ' . $request->name);

            $fileName = null;
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $fileName = 'user_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/user'), $fileName);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'avatar' => $fileName,
                'role' => $request->role,
                'status' => $request->status,
                'password' => $request->password ? bcrypt($request->password) : null,
            ]);

            Log::info('Data pelanggan berhasil ditambahkan.', [
                'id' => $user->id,
                'name' => $user->name,
            ]);

            return redirect()->back()->with('success', 'Data pelanggan berhasil ditambahkan!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->with('error', 'Terjadi kesalahan validasi: ' . implode(', ', $e->validator->errors()->all()))
                ->withInput();
        } catch (Exception $e) {
            Log::error('GAGAL menambahkan data pelanggan.', [
                'error_message' => $e->getMessage(),
                'user_input' => $request->except('avatar'),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function indexPelanggan(Request $request)
    {
        $search = $request->input('search');

        $pelanggan = User::query()->whereNull('role')
            ->where(['status' => 'Aktif'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%");
                });
            })->get();

        return view('admin.pelanggan', compact('pelanggan', 'search'));
    }

    public function updatePelanggan(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $id,
                'phone' => 'required|numeric|digits_between:10,15',
                'address' => 'required|max:255',
                'avatar' => 'nullable|image|mimes:jpg,png,jpeg|max:30720',
                'role' => 'nullable|max:10',
                'status' => 'nullable|max:20',
                'password' => 'nullable|min:8|confirmed',
            ]);

            Log::info('Mencoba mengupdate data pelanggan: ' . $request->name);

            $userOld = User::find($id);

            $fileName = $userOld->avatar;
            if ($request->hasFile('avatar')) {
                if ($userOld->avatar && file_exists(public_path('uploads/user/' . $userOld->avatar))) {
                    @unlink(public_path('uploads/user/' . $userOld->avatar));
                }

                $file = $request->file('avatar');
                $fileName = 'user_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/user'), $fileName);
            }

            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'avatar' => $fileName,
                'role' => $request->role,
                'status' => $request->status,
            ];

            if ($request->password) {
                $updateData['password'] = bcrypt($request->password);
            }

            $userOld->update($updateData);

            Log::info('Data pelanggan berhasil diupdate.', [
                'id' => $id,
                'name' => $request->name,
            ]);

            return redirect()->back()->with('success', 'Data pelanggan berhasil diupdate!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->with('error', 'Terjadi kesalahan validasi: ' . implode(', ', $e->validator->errors()->all()))
                ->withInput();
        } catch (Exception $e) {
            Log::error('GAGAL mengupdate data pelanggan.', [
                'error_message' => $e->getMessage(),
                'user_input' => $request->except('avatar'),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                ->withInput();
        }
    }
}
