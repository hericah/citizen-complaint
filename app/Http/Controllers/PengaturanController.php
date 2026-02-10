<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PengaturanController extends Controller
{
    /**
     * Tampilkan halaman profil pengguna
     */
    public function profil()
    {
        $email = session('email');
        $user = null;

        if ($email) {
            $user = DB::table('pengguna')
                ->leftjoin('peran_pengguna', 'pengguna.id', '=', 'peran_pengguna.pengguna_id')
                ->leftjoin('peran', 'peran_pengguna.peran_id', '=', 'peran.id')
                ->where('pengguna.email', $email)
                ->select('pengguna.*', 'peran.id as peran_id', 'peran.nama_peran')
                ->first();
        }

        return Inertia::render('Admin/Pengaturan/Profil', [
            'user' => $user,
        ]);
    }

    /**
     * Update profil pengguna
     */
    public function updateProfil(Request $request)
    {
        $email = session('email');
        $user = DB::table('pengguna')->where('email', $email)->first();
        $userId = $user?->id ?? 0;

        $validated = $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email,' . $userId,
        ]);

        DB::table('pengguna')->where('id', $userId)->update($validated);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Tampilkan halaman ubah password
     */
    public function ubahPassword()
    {
        $email = session('email');
        $user = null;

        if ($email) {
            $user = DB::table('pengguna')
                ->leftjoin('peran_pengguna', 'pengguna.id', '=', 'peran_pengguna.pengguna_id')
                ->leftjoin('peran', 'peran_pengguna.peran_id', '=', 'peran.id')
                ->where('pengguna.email', $email)
                ->select('pengguna.*', 'peran.id as peran_id', 'peran.nama_peran')
                ->first();
        }

        return Inertia::render('Admin/Pengaturan/UbahPassword', [
            'user' => $user,
        ]);
    }

    /**
     * Update password pengguna
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'password_lama' => 'required|string',
            'password_baru' => 'required|string|min:6|confirmed',
        ]);

        // Validasi password lama
        $email = session('email');
        $user = DB::table('pengguna')->where('email', $email)->first();

        if (!$user || !\Illuminate\Support\Facades\Hash::check($validated['password_lama'], $user->password_hash)) {
            return redirect()->back()->withErrors(['password_lama' => 'Password lama tidak sesuai']);
        }

        DB::table('pengguna')->where('id', $user->id)->update([
            'password_hash' => \Illuminate\Support\Facades\Hash::make($validated['password_baru']),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah');
    }

    /**
     * Tampilkan halaman pengaturan sistem
     */
    public function sistem()
    {
        $email = session('email');
        $user = null;

        if ($email) {
            $user = DB::table('pengguna')
                ->leftjoin('peran_pengguna', 'pengguna.id', '=', 'peran_pengguna.pengguna_id')
                ->leftjoin('peran', 'peran_pengguna.peran_id', '=', 'peran.id')
                ->where('pengguna.email', $email)
                ->select('pengguna.*', 'peran.id as peran_id', 'peran.nama_peran')
                ->first();
        }

        return Inertia::render('Admin/Pengaturan/PengaturanSistem', [
            'user' => $user,
        ]);
    }
}
