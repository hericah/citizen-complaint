<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AksesAduanSeeder extends Seeder
{
    /**
     * Seed tabel akses_aduan dengan tingkat akses
     */
    public function run(): void
    {
        $akses = [
            [
                'nama_akses_aduan' => 'Publik',
                'keterangan' => 'Aduan dapat dilihat oleh semua orang (publik)'
            ],
            [
                'nama_akses_aduan' => 'Terbatas',
                'keterangan' => 'Aduan hanya dapat dilihat oleh pelapor dan instansi terkait'
            ],
            [
                'nama_akses_aduan' => 'Rahasia',
                'keterangan' => 'Aduan bersifat rahasia dan hanya dapat dilihat oleh admin'
            ],
        ];

        foreach ($akses as $ak) {
            DB::table('akses_aduan')->insert([
                'nama_akses_aduan' => $ak['nama_akses_aduan'],
                'keterangan' => $ak['keterangan'],
                'tanggal_dibuat' => now(),
                'tanggal_diubah' => now(),
            ]);
        }

        $this->command->info('✅ 3 Akses Aduan berhasil dibuat: Publik, Terbatas, Rahasia');
    }
}
