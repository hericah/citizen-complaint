# Fix: Duplikasi Data Kategori dan Jenis Aduan

## Masalah
Data kategori aduan dan jenis aduan (akses aduan) menjadi duplikat ketika seeder dijalankan berkali-kali.

## Penyebab
`MasterDataSeeder.php` menggunakan `DB::table()->insert()` yang akan selalu menambahkan data baru tanpa mengecek apakah data sudah ada.

## Solusi
Mengubah `insert()` menjadi `updateOrInsert()` agar seeder bersifat **idempotent** (aman dijalankan berkali-kali).

### Perubahan di `MasterDataSeeder.php`

**Sebelum:**
```php
DB::table('kategori_aduan')->insert($kategori);
```

**Sesudah:**
```php
DB::table('kategori_aduan')->updateOrInsert(
    ['nama_kategori' => $kategori['nama_kategori']],
    $kategori
);
```

## Cara Membersihkan Data Duplikat

Jika sudah terlanjur ada data duplikat, jalankan:

```bash
docker-compose -f docker-compose.dev.yml exec app php artisan migrate:fresh --seed
```

> ⚠️ **WARNING**: Perintah ini akan **menghapus semua data** di database dan membuat ulang dari awal!

## Hasil
✅ Seeder sekarang aman dijalankan berkali-kali tanpa membuat data duplikat  
✅ Data master tetap konsisten meskipun `setup.sh` dijalankan ulang
