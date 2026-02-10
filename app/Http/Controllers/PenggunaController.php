<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Peran;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PenggunaController extends Controller
{
    /**
     * Display a listing of pengguna
     */
    public function index()
    {
        $pengguna = Pengguna::with('peran', 'opd')->paginate(10);

        return Inertia::render('Admin/Master/Pengguna/Index', [
            'pengguna' => $pengguna,
        ]);
    }

    /**
     * Show the form for creating a new pengguna
     */
    public function create()
    {
        $peran = Peran::all();

        return Inertia::render('Admin/Master/Pengguna/Create', [
            'peran' => $peran,
        ]);
    }

    /**
     * Store a newly created pengguna in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'password_hash' => 'required|string|min:6',
            'status_aktif' => 'boolean',
        ]);

        $pengguna = Pengguna::create($validated);

        if ($request->has('peran_ids')) {
            $pengguna->peran()->sync($request->peran_ids);
        }

        return redirect()->route('master.pengguna')->with('success', 'Pengguna berhasil dibuat');
    }

    /**
     * Show the form for editing pengguna
     */
    public function edit(Pengguna $pengguna)
    {
        $peran = Peran::all();
        $selectedPeran = $pengguna->peran()->pluck('peran_id')->toArray();

        return Inertia::render('Admin/Master/Pengguna/Edit', [
            'pengguna' => $pengguna,
            'peran' => $peran,
            'selectedPeran' => $selectedPeran,
        ]);
    }

    /**
     * Update pengguna in storage
     */
    public function update(Request $request, Pengguna $pengguna)
    {
        $validated = $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email,' . $pengguna->id,
            'status_aktif' => 'boolean',
        ]);

        $pengguna->update($validated);

        if ($request->has('peran_ids')) {
            $pengguna->peran()->sync($request->peran_ids);
        }

        return redirect()->route('master.pengguna')->with('success', 'Pengguna berhasil diperbarui');
    }

    /**
     * Remove pengguna from storage
     */
    public function destroy(Pengguna $pengguna)
    {
        $pengguna->delete();
        return redirect()->route('master.pengguna')->with('success', 'Pengguna berhasil dihapus');
    }
}
