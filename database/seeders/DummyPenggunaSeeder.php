<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DummyPenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'nama_pengguna' => 'budi.santoso',
                'email' => 'budi.santoso@example.test',
                'password_hash' => Hash::make('password'),
                'status_aktif' => 1,
            ],
            [
                'nama_pengguna' => 'ani.wijaya',
                'email' => 'ani.wijaya@example.test',
                'password_hash' => Hash::make('password'),
                'status_aktif' => 1,
            ],
            [
                'nama_pengguna' => 'rudi.hermawan',
                'email' => 'rudi.hermawan@example.test',
                'password_hash' => Hash::make('password'),
                'status_aktif' => 1,
            ],
        ];

        // Create users if not exist
        $createdUserIds = [];
        foreach ($users as $u) {
            $existing = DB::table('pengguna')->where('nama_pengguna', $u['nama_pengguna'])->first();
            if (!$existing) {
                $id = DB::table('pengguna')->insertGetId([
                    'nama_pengguna' => $u['nama_pengguna'],
                    'email' => $u['email'],
                    'password_hash' => $u['password_hash'],
                    'status_verifikasi' => 1,
                    'email_verifikasi' => now(),
                    'status_aktif' => $u['status_aktif'],
                ]);
                $createdUserIds[$u['nama_pengguna']] = $id;
            } else {
                $createdUserIds[$u['nama_pengguna']] = $existing->id;
            }
        }

        // Attach these pengguna to all OPD entries via opd_pengguna pivot
        $opds = DB::table('opd')->get();
        foreach ($opds as $opd) {
            foreach ($createdUserIds as $username => $uid) {
                $exists = DB::table('opd_pengguna')
                    ->where('opd_id', $opd->id)
                    ->where('pengguna_id', $uid)
                    ->first();
                if (!$exists) {
                    DB::table('opd_pengguna')->insert([
                        'opd_id' => $opd->id,
                        'pengguna_id' => $uid,
                    ]);
                }
            }
        }
    }
}
