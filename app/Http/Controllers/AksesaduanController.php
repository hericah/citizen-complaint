<?php

namespace App\Http\Controllers;

use App\Models\AksesAduan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AksesaduanController extends Controller
{
    /**
     * Display a listing of akses aduan
     */
    public function index()
    {
        $aksesAduan = AksesAduan::paginate(10);

        return Inertia::render('Admin/Master/AksesAduan/Index', [
            'aksesAduan' => $aksesAduan,
        ]);
    }

    /**
     * Show the form for creating a new akses aduan
     */
    public function create()
    {
        return Inertia::render('Admin/Master/AksesAduan/Create');
    }

    /**
     * Store a newly created akses aduan in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_akses_aduan' => 'required|string|max:255|unique:akses_aduan,nama_akses_aduan',
            'keterangan' => 'required|string',
        ]);

        AksesAduan::create($validated);

        return redirect()->route('master.aksesaduan')->with('success', 'Akses Aduan berhasil dibuat');
    }

    /**
     * Show the form for editing akses aduan
     */
    public function edit(AksesAduan $aksesAduan)
    {
        return Inertia::render('Admin/Master/AksesAduan/Edit', [
            'aksesAduan' => $aksesAduan,
        ]);
    }

    /**
     * Update akses aduan in storage
     */
    public function update(Request $request, AksesAduan $aksesAduan)
    {
        $validated = $request->validate([
            'nama_akses_aduan' => 'required|string|max:255|unique:akses_aduan,nama_akses_aduan,' . $aksesAduan->id,
            'keterangan' => 'required|string',
        ]);

        $aksesAduan->update($validated);

        return redirect()->route('master.aksesaduan')->with('success', 'Akses Aduan berhasil diperbarui');
    }

    /**
     * Remove akses aduan from storage
     */
    public function destroy(AksesAduan $aksesAduan)
    {
        $aksesAduan->delete();
        return redirect()->route('master.aksesaduan')->with('success', 'Akses Aduan berhasil dihapus');
    }
}
