<?php

namespace App\Http\Controllers;

use App\Models\KategoriAduan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KategoriController extends Controller
{
    /**
     * Display a listing of kategori aduan
     */
    public function index()
    {
        $kategori = KategoriAduan::paginate(10);

        return Inertia::render('Admin/Master/KategoriAduan/Index', [
            'kategori' => $kategori,
        ]);
    }

    /**
     * Show the form for creating a new kategori aduan
     */
    public function create()
    {
        return Inertia::render('Admin/Master/KategoriAduan/Create');
    }

    /**
     * Store a newly created kategori aduan in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_aduan,nama_kategori',
            'keterangan' => 'required|string',
        ]);

        KategoriAduan::create($validated);

        return redirect()->route('master.kategori')->with('success', 'Kategori Aduan berhasil dibuat');
    }

    /**
     * Show the form for editing kategori aduan
     */
    public function edit(KategoriAduan $kategoriAduan)
    {
        return Inertia::render('Admin/Master/KategoriAduan/Edit', [
            'kategori' => $kategoriAduan,
        ]);
    }

    /**
     * Update kategori aduan in storage
     */
    public function update(Request $request, KategoriAduan $kategoriAduan)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_aduan,nama_kategori,' . $kategoriAduan->id,
            'keterangan' => 'required|string',
        ]);

        $kategoriAduan->update($validated);

        return redirect()->route('master.kategori')->with('success', 'Kategori Aduan berhasil diperbarui');
    }

    /**
     * Remove kategori aduan from storage
     */
    public function destroy(KategoriAduan $kategoriAduan)
    {
        $kategoriAduan->delete();
        return redirect()->route('master.kategori')->with('success', 'Kategori Aduan berhasil dihapus');
    }
}
