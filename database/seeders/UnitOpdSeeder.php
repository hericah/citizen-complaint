<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitOpdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Remove existing unit_opd data then insert fresh example units with nama_pengguna
        DB::table('unit_opd')->delete();

        $opds = DB::table('opd')->get();

        foreach ($opds as $opd) {
            DB::table('unit_opd')->insert([
                [
                    'opd_id' => $opd->id,
                    'nama_unit' => 'Sekretariat ' . $opd->nama_opd,
                    'kode_unit' => null,
                    'nama_pengguna' => 'budi.santoso',
                    'tanggal_dibuat' => now(),
                    'tanggal_diubah' => now(),
                ],
                [
                    'opd_id' => $opd->id,
                    'nama_unit' => 'Teknis ' . $opd->nama_opd,
                    'kode_unit' => null,
                    'nama_pengguna' => 'ani.wijaya',
                    'tanggal_dibuat' => now(),
                    'tanggal_diubah' => now(),
                ],
                [
                    'opd_id' => $opd->id,
                    'nama_unit' => 'Pelayanan ' . $opd->nama_opd,
                    'kode_unit' => null,
                    'nama_pengguna' => 'rudi.hermawan',
                    'tanggal_dibuat' => now(),
                    'tanggal_diubah' => now(),
                ],
            ]);
        }
    }
}
