<?php

namespace App\Http\Controllers;

use App\Models\UnitOpd;
use App\Models\OPD;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UnitOpdController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');

        $query = UnitOpd::with('opd');

        if ($q) {
            $query->where('nama_unit', 'like', "%{$q}%");
        }

        $units = $query->orderBy('tanggal_dibuat', 'desc')
            ->paginate(10)
            ->appends($request->only('q'));

        return Inertia::render('Admin/Master/OPD/UnitOpd/Index', [
            'user' => session()->all(),
            'units' => $units,
        ]);
    }

    public function create()
    {
        $opdList = OPD::select('id', 'nama_opd')->orderBy('nama_opd')->get();
        return Inertia::render('Admin/Master/OPD/UnitOpd/Create', [
            'user' => session()->all(),
            'opdList' => $opdList,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'opd_id' => 'required|exists:opd,id',
            'nama_unit' => 'required|string|max:255',
            'kode_unit' => 'nullable|string|max:50',
        ]);

        UnitOpd::create([
            'opd_id' => $validated['opd_id'],
            'nama_unit' => $validated['nama_unit'],
            'kode_unit' => $validated['kode_unit'] ?? null,
        ]);

        return redirect()->route('master.unitopd')->with('success', 'Unit OPD berhasil ditambahkan');
    }

    public function edit(UnitOpd $unitOpd)
    {
        $opdList = OPD::select('id', 'nama_opd')->orderBy('nama_opd')->get();
        return Inertia::render('Admin/Master/OPD/UnitOpd/Edit', [
            'user' => session()->all(),
            'unit' => $unitOpd,
            'opdList' => $opdList,
        ]);
    }

    public function update(Request $request, UnitOpd $unitOpd)
    {
        $validated = $request->validate([
            'opd_id' => 'required|exists:opd,id',
            'nama_unit' => 'required|string|max:255',
            'kode_unit' => 'nullable|string|max:50',
        ]);

        $unitOpd->update([
            'opd_id' => $validated['opd_id'],
            'nama_unit' => $validated['nama_unit'],
            'kode_unit' => $validated['kode_unit'] ?? null,
        ]);

        return redirect()->route('master.unitopd')->with('success', 'Unit OPD berhasil diperbarui');
    }

    public function destroy(UnitOpd $unitOpd)
    {
        $unitOpd->delete();
        return redirect()->route('master.unitopd')->with('success', 'Unit OPD berhasil dihapus');
    }
}
