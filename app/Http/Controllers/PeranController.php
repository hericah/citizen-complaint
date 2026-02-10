<?php

namespace App\Http\Controllers;

use App\Models\Peran;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PeranController extends Controller
{
    /**
     * Display a listing of peran
     */
    public function index()
    {
        $peran = Peran::paginate(10);

        return Inertia::render('Admin/Master/Peran/Index', [
            'peran' => $peran,
        ]);
    }

    /**
     * Show the form for creating a new peran
     */
    public function create()
    {
        return Inertia::render('Admin/Master/Peran/Create');
    }

    /**
     * Store a newly created peran in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_peran' => 'required|string|max:255|unique:peran,nama_peran',
        ]);

        Peran::create($validated);

        return redirect()->route('master.peran')->with('success', 'Peran berhasil dibuat');
    }

    /**
     * Show the form for editing peran
     */
    public function edit(Peran $peran)
    {
        return Inertia::render('Admin/Master/Peran/Edit', [
            'peran' => $peran,
        ]);
    }

    /**
     * Update peran in storage
     */
    public function update(Request $request, Peran $peran)
    {
        $validated = $request->validate([
            'nama_peran' => 'required|string|max:255|unique:peran,nama_peran,' . $peran->id,
        ]);

        $peran->update($validated);

        return redirect()->route('master.peran')->with('success', 'Peran berhasil diperbarui');
    }

    /**
     * Remove peran from storage
     */
    public function destroy(Peran $peran)
    {
        $peran->delete();
        return redirect()->route('master.peran')->with('success', 'Peran berhasil dihapus');
    }
}
