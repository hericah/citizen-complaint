<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Seed tabel pengguna dengan data awal
     */
    public function run(): void
    {
        $pengguna = [
            [
                'nama_pengguna' => 'Admin System',
                'email' => 'admin@pemalang.go.id',
                'password_hash' => Hash::make('password123'),
                'status_verifikasi' => true,
                'status_aktif' => true,
            ],
            [
                'nama_pengguna' => 'Operator OPD',
                'email' => 'operator@pemalang.go.id',
                'password_hash' => Hash::make('password123'),
                'status_verifikasi' => true,
                'status_aktif' => true,
            ],
            [
                'nama_pengguna' => 'Staff Dinas PU',
                'email' => 'staff.pu@pemalang.go.id',
                'password_hash' => Hash::make('password123'),
                'status_verifikasi' => true,
                'status_aktif' => true,
            ],
        ];

        foreach ($pengguna as $user) {
            $userId = DB::table('pengguna')->insertGetId([
                'nama_pengguna' => $user['nama_pengguna'],
                'email' => $user['email'],
                'password_hash' => $user['password_hash'],
                'status_verifikasi' => $user['status_verifikasi'],
                'status_aktif' => $user['status_aktif'],
                'tanggal_dibuat' => now(),
                'tanggal_diubah' => now(),
            ]);

            // Assign roles
            if (strpos($user['email'], 'admin') !== false) {
                DB::table('peran_pengguna')->insert([
                    'pengguna_id' => $userId,
                    'peran_id' => 1, // Admin role
                ]);
            } else {
                DB::table('peran_pengguna')->insert([
                    'pengguna_id' => $userId,
                    'peran_id' => 2, // OPD role
                ]);
            }
        }

        $this->command->info('✅ 3 Pengguna berhasil dibuat dengan role yang sesuai');
    }
}
