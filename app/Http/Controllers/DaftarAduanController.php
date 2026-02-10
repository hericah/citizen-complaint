<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DaftarAduanController extends Controller
{
    /**
     * Tampilkan daftar semua aduan
     */
    public function index(Request $request)
    {
        $q = $request->input('q');
        $status = $request->input('status');
        $kategori = $request->input('kategori');

        $query = Aduan::with(['kategoriAduan', 'statusAduan', 'masyarakat', 'aksesAduan'])
            ->orderBy('tanggal_lapor', 'desc');

        if ($q) {
            $query->where(function ($b) use ($q) {
                $b->where('no_aduan', 'like', "%{$q}%")
                    ->orWhere('lokasi', 'like', "%{$q}%");
            });
        }

        if ($status) {
            $query->whereHas('statusAduan', function ($b) use ($status) {
                $b->where('nama_status', $status);
            });
        }

        if ($kategori) {
            $query->whereHas('kategoriAduan', function ($b) use ($kategori) {
                $b->where('nama_kategori', $kategori);
            });
        }

        $aduan = $query->paginate(10)->appends($request->only('q', 'status', 'kategori'));

        // Statistik status aduan
        $stats = [
            'diajukan' => Aduan::whereHas('statusAduan', function ($q) {
                $q->where('nama_status', 'Diajukan');
            })->count(),
            'diverifikasi' => Aduan::whereHas('statusAduan', function ($q) {
                $q->where('nama_status', 'Diverifikasi');
            })->count(),
            'diproses' => Aduan::whereHas('statusAduan', function ($q) {
                $q->where('nama_status', 'Diproses');
            })->count(),
            'selesai' => Aduan::whereHas('statusAduan', function ($q) {
                $q->where('nama_status', 'Selesai');
            })->count(),
            'ditolak' => Aduan::whereHas('statusAduan', function ($q) {
                $q->where('nama_status', 'Ditolak');
            })->count(),
        ];

        return Inertia::render('Admin/ManajemenAduan/DaftarAduan', [
            'aduan' => $aduan,
            'stats' => $stats,
        ]);
    }

    /**
     * Tampilkan detail aduan
     */
    public function show(Aduan $aduan)
    {
        $aduan->load(['kategoriAduan', 'statusAduan', 'masyarakat', 'aksesAduan', 'riwayatStatus', 'tanggapan']);

        return Inertia::render('Admin/ManajemenAduan/DetailAduan', [
            'aduan' => $aduan,
        ]);
    }

    /**
     * Update status aduan
     */
    public function updateStatus(Request $request, Aduan $aduan)
    {
        $validated = $request->validate([
            'status_aduan_id' => 'required|exists:status_aduan,id',
            'keterangan' => 'nullable|string',
        ]);

        $aduan->update(['status_aduan_id' => $validated['status_aduan_id']]);

        if ($validated['keterangan']) {
            // determine pengguna_id from session or fallback
            $emailSess = session('email');
            $namaSess = session('nama_pengguna');
            $penggunaRow = DB::table('pengguna')->where('email', $emailSess)->orWhere('nama_pengguna', $namaSess)->first();
            $penggunaId = $penggunaRow?->id ?? DB::table('pengguna')->value('id') ?? 1;

            \App\Models\RiwayatStatusAduan::create([
                'aduan_id' => $aduan->id,
                'status_aduan_id' => $validated['status_aduan_id'],
                'catatan' => $validated['keterangan'],
                'pengguna_id' => $penggunaId,
                'waktu_status_aduan' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Status aduan berhasil diperbarui');
    }
}
