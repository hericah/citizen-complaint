<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriAduanSeeder extends Seeder
{
    /**
     * Seed tabel kategori_aduan dengan kategori standar
     */
    public function run(): void
    {
        $kategori = [
            [
                'nama_kategori' => 'Infrastruktur Jalan',
                'keterangan' => 'Pengaduan terkait kondisi jalan yang rusak, berlubang, atau memerlukan perbaikan'
            ],
            [
                'nama_kategori' => 'Layanan Listrik',
                'keterangan' => 'Pengaduan terkait mati listrik, gangguan distribusi, atau masalah kelistrikan umum'
            ],
            [
                'nama_kategori' => 'Layanan Air',
                'keterangan' => 'Pengaduan terkait gangguan pasokan air bersih atau kualitas air yang tidak memenuhi standar'
            ],
            [
                'nama_kategori' => 'Kebersihan & Lingkungan',
                'keterangan' => 'Pengaduan terkait sampah menumpuk, banjir, atau masalah lingkungan lainnya'
            ],
            [
                'nama_kategori' => 'Pendidikan',
                'keterangan' => 'Pengaduan terkait fasilitas pendidikan, manajemen sekolah, atau masalah pendidikan'
            ],
            [
                'nama_kategori' => 'Kesehatan',
                'keterangan' => 'Pengaduan terkait pelayanan kesehatan, fasilitas medis, atau layanan kesehatan umum'
            ],
            [
                'nama_kategori' => 'Transportasi & Lalu Lintas',
                'keterangan' => 'Pengaduan terkait kemacetan, keamanan jalan, atau masalah transportasi umum'
            ],
            [
                'nama_kategori' => 'Keamanan & Ketertiban',
                'keterangan' => 'Pengaduan terkait keamanan masyarakat, kriminalitas, atau masalah ketertiban'
            ],
        ];

        foreach ($kategori as $kat) {
            DB::table('kategori_aduan')->insert([
                'nama_kategori' => $kat['nama_kategori'],
                'keterangan' => $kat['keterangan'],
                'tanggal_dibuat' => now(),
                'tanggal_diubah' => now(),
            ]);
        }

        $this->command->info('✅ 8 Kategori Aduan berhasil dibuat');
    }
}
