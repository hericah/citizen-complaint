<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get necessary IDs
        $masyarakatId = DB::table('masyarakat')->first()->id ?? null;
        $kategoriIds = DB::table('kategori_aduan')->pluck('id')->toArray();
        $aksesPublikId = DB::table('akses_aduan')->where('nama_akses_aduan', 'Publik')->value('id');
        
        $statusIds = [
            'Diajukan' => DB::table('status_aduan')->where('nama_status', 'Diajukan')->value('id'),
            'Diverifikasi' => DB::table('status_aduan')->where('nama_status', 'Diverifikasi')->value('id'),
            'Diproses' => DB::table('status_aduan')->where('nama_status', 'Diproses')->value('id'),
            'Selesai' => DB::table('status_aduan')->where('nama_status', 'Selesai')->value('id'),
        ];

        // Sample complaints data
        $complaints = [
            [
                'isi_aduan' => 'Jalan berlubang di Jalan Raya Pemalang mengganggu kenyamanan pengendara. Mohon segera diperbaiki.',
                'lokasi' => 'Jl. Raya Pemalang, Pemalang Tengah',
                'latitude' => -6.8951,
                'longitude' => 109.3784,
                'status' => 'Selesai',
            ],
            [
                'isi_aduan' => 'Lampu jalan mati di perumahan Griya Pemalang sejak 3 hari yang lalu. Mohon segera diperbaiki untuk keamanan warga.',
                'lokasi' => 'Perumahan Griya Pemalang',
                'latitude' => -6.8923,
                'longitude' => 109.3801,
                'status' => 'Diproses',
            ],
            [
                'isi_aduan' => 'Sampah menumpuk di TPS Pasar Pemalang tidak diangkut selama seminggu. Menimbulkan bau tidak sedap.',
                'lokasi' => 'TPS Pasar Pemalang',
                'latitude' => -6.8967,
                'longitude' => 109.3756,
                'status' => 'Selesai',
            ],
            [
                'isi_aduan' => 'Pohon tumbang menghalangi jalan di Jalan Pemuda akibat hujan deras kemarin malam.',
                'lokasi' => 'Jl. Pemuda, Pemalang',
                'latitude' => -6.8945,
                'longitude' => 109.3812,
                'status' => 'Diproses',
            ],
            [
                'isi_aduan' => 'Saluran air tersumbat menyebabkan banjir di perumahan Taman Sari saat hujan.',
                'lokasi' => 'Perumahan Taman Sari',
                'latitude' => -6.8978,
                'longitude' => 109.3745,
                'status' => 'Selesai',
            ],
            [
                'isi_aduan' => 'Trotoar rusak di depan Kantor Pos Pemalang membahayakan pejalan kaki.',
                'lokasi' => 'Jl. Veteran, Pemalang',
                'latitude' => -6.8934,
                'longitude' => 109.3789,
                'status' => 'Diproses',
            ],
            [
                'isi_aduan' => 'Rambu lalu lintas hilang di perempatan Jalan Sudirman-Gatot Subroto.',
                'lokasi' => 'Perempatan Jl. Sudirman',
                'latitude' => -6.8956,
                'longitude' => 109.3798,
                'status' => 'Selesai',
            ],
            [
                'isi_aduan' => 'Taman kota tidak terawat, rumput liar tumbuh tinggi dan fasilitas bermain rusak.',
                'lokasi' => 'Taman Kota Pemalang',
                'latitude' => -6.8912,
                'longitude' => 109.3823,
                'status' => 'Diproses',
            ],
        ];

        // Create masyarakat user if not exists
        if (!$masyarakatId) {
            // Check if warga user already exists
            $existingPengguna = DB::table('pengguna')->where('email', 'warga@pemalang.go.id')->first();
            
            if ($existingPengguna) {
                // Get existing masyarakat record
                $masyarakatId = DB::table('masyarakat')->where('pengguna_id', $existingPengguna->id)->value('id');
            } else {
                // Create new warga user
                $penggunaId = DB::table('pengguna')->insertGetId([
                    'nama_pengguna' => 'Warga Pemalang',
                    'email' => 'warga@pemalang.go.id',
                    'password_hash' => bcrypt('warga123'),
                    'status_verifikasi' => true,
                    'email_verifikasi' => now(),
                    'status_aktif' => true,
                    'tanggal_dibuat' => now(),
                    'tanggal_diubah' => now(),
                ]);

                // Assign role Masyarakat
                $roleMasyarakatId = DB::table('peran')->where('nama_peran', 'Masyarakat')->value('id');
                DB::table('peran_pengguna')->insert([
                    'pengguna_id' => $penggunaId,
                    'peran_id' => $roleMasyarakatId,
                ]);

                // Create masyarakat record
                $masyarakatId = DB::table('masyarakat')->insertGetId([
                    'pengguna_id' => $penggunaId,
                    'nik' => '3328' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT) . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                    'nama_lengkap' => 'Warga Pemalang',
                    'tanggal_lahir' => '1990-01-01',
                    'jenis_kelamin' => 'L',
                    'alamat' => 'Pemalang, Jawa Tengah',
                    'no_telepon' => '081234567890',
                    'tanggal_dibuat' => now(),
                    'tanggal_diubah' => now(),
                ]);
            }
        }

        // Insert complaints
        foreach ($complaints as $index => $complaint) {
            $kategoriId = $kategoriIds[array_rand($kategoriIds)];
            $statusId = $statusIds[$complaint['status']];
            
            $aduanId = DB::table('aduan')->insertGetId([
                'no_aduan' => 'ADU-' . date('Ymd') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'tanggal_lapor' => now()->subDays(rand(1, 30)),
                'isi_aduan' => $complaint['isi_aduan'],
                'lokasi' => $complaint['lokasi'],
                'latitude' => $complaint['latitude'],
                'longitude' => $complaint['longitude'],
                'foto' => null, // No photos for now
                'masyarakat_id' => $masyarakatId,
                'kategori_aduan_id' => $kategoriId,
                'akses_aduan_id' => $aksesPublikId,
                'status_aduan_id' => $statusId,
                'tanggal_selesai' => $complaint['status'] === 'Selesai' ? now()->subDays(rand(1, 5)) : null,
                'tanggal_dibuat' => now()->subDays(rand(1, 30)),
                'tanggal_diubah' => now()->subDays(rand(0, 5)),
            ]);

            // Add status history
            DB::table('riwayat_status_aduan')->insert([
                'aduan_id' => $aduanId,
                'status_aduan_id' => $statusId,
                'waktu_status_aduan' => now()->subDays(rand(0, 5)),
                'catatan' => 'Status: ' . $complaint['status'],
                'pengguna_id' => $masyarakatId,
                'tanggal_dibuat' => now()->subDays(rand(0, 5)),
                'tanggal_diubah' => now()->subDays(rand(0, 5)),
            ]);
        }

        echo "✅ " . count($complaints) . " aduan sample berhasil dibuat\n";
    }
}
