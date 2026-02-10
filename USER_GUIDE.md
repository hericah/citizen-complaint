# User Guide - Citizen Complaint System

## 📋 Daftar Isi
1. [Akses Sistem](#akses-sistem)
2. [Master Data Management](#master-data-management)
3. [Manajemen Aduan](#manajemen-aduan)
4. [Laporan](#laporan)
5. [Pengaturan Akun](#pengaturan-akun)

---

## 🔐 Akses Sistem

### Login

**Cara Login dengan Username & Password:**
1. Buka aplikasi di http://localhost:8000 atau domain Anda
2. Klik menu "Masuk" atau "Login"
3. Masukkan email/username dan password
4. Klik tombol "Masuk"
5. Anda akan diarahkan ke Dashboard

**Cara Login dengan Google:**
1. Buka halaman login
2. Klik tombol "Masuk dengan Google"
3. Pilih akun Google Anda
4. Klik "Allow" untuk memberikan akses
5. Sistem akan membuat akun otomatis jika belum terdaftar
6. Anda akan langsung diarahkan ke Dashboard

### Register

**Cara Daftar Akun Baru:**
1. Klik "Daftar" atau "Belum punya akun?"
2. Isi form:
   - **Nama Pengguna**: Nama lengkap Anda
   - **Email**: Alamat email aktif
   - **Password**: Password minimal 6 karakter
   - **Konfirmasi Password**: Ulangi password
3. Klik "Daftar"
4. Akun Anda akan dibuat dan siap digunakan

**Alternatif: Daftar dengan Google:**
1. Klik "Daftar dengan Google"
2. Pilih akun Google Anda
3. Klik "Allow"
4. Akun Anda akan dibuat otomatis dari data Google

### Logout
1. Klik avatar/profile Anda di corner kanan atas
2. Pilih "Logout"
3. Anda akan diarahkan ke halaman login

---

## 👥 Master Data Management

Master Data adalah data referensi yang digunakan di seluruh sistem. Hanya Admin yang dapat mengelola master data.

### 1. Manajemen Pengguna

**Akses:**
- Menu → Master Data → Pengguna

**Features:**
- **List Pengguna**: Melihat semua pengguna terdaftar
- **Tambah Pengguna**: Buat akun pengguna baru
- **Edit Pengguna**: Ubah data pengguna yang ada
- **Hapus Pengguna**: Hapus pengguna dari sistem

**Cara Menambah Pengguna:**
1. Klik "Tambah Data" atau tombol "+"
2. Isi form:
   - **Nama Pengguna**: Nama lengkap
   - **Email**: Email pengguna
   - **Password**: Password default
   - **Status Verifikasi**: Verified/Unverified
   - **Status Aktif**: Aktif/Nonaktif
3. Klik "Simpan"

**Cara Edit Pengguna:**
1. Klik tombol "Edit" pada baris pengguna
2. Ubah data yang diperlukan
3. Klik "Simpan"

**Cara Hapus Pengguna:**
1. Klik tombol "Hapus" pada baris pengguna
2. Konfirmasi dengan klik "Ya, Hapus"

---

### 2. Manajemen Peran (Role)

**Akses:**
- Menu → Master Data → Peran

**Peran yang Tersedia:**
- **Admin**: Akses penuh ke sistem
- **OPD**: Operator OPD untuk memproses aduan
- **Masyarakat**: User biasa untuk membuat aduan

**Cara Mengelola Peran:**
1. List menampilkan semua peran
2. Edit untuk mengubah deskripsi peran
3. Hapus untuk menghapus peran (tidak disarankan untuk peran default)

---

### 3. Manajemen Kategori Aduan

**Akses:**
- Menu → Master Data → Kategori Aduan

**Cara Menambah Kategori:**
1. Klik "Tambah Data"
2. Isi form:
   - **Nama Kategori**: Misal "Jalan Rusak", "Sampah", "Saluran Air"
   - **Keterangan**: Deskripsi kategori (optional)
3. Klik "Simpan"

**Contoh Kategori:**
- Jalan Rusak
- Sampah Berserakan
- Saluran Air Tersumbat
- Penerangan Jalan Mati
- Keamanan
- Kesehatan
- Pendidikan
- Air Bersih

---

### 4. Manajemen Akses Aduan

**Akses:**
- Menu → Master Data → Akses Aduan

**Tingkat Akses:**
- **Publik**: Aduan dapat dilihat siapa saja
- **Terbatas**: Hanya pihak tertentu yang bisa lihat
- **Rahasia**: Hanya pembuat dan admin yang bisa lihat

**Cara Menambah Akses Level:**
1. Klik "Tambah Data"
2. Isi:
   - **Nama Akses**: Publik/Terbatas/Rahasia
   - **Keterangan**: Penjelasan detail
3. Klik "Simpan"

---

## 📝 Manajemen Aduan

Menu untuk mengelola semua pengaduan masyarakat yang masuk ke sistem.

### 1. Daftar Aduan

**Akses:**
- Menu → Manajemen Aduan → Daftar Aduan

**Features:**
- **List Semua Aduan**: Tampilan tabel dengan kolom:
  - No. Aduan: Nomor unik aduan
  - Tanggal: Tanggal aduan dibuat
  - Kategori: Kategori masalah
  - Lokasi: Lokasi kejadian
  - Status: Status pengolahan (Diajukan, Diverifikasi, Diproses, Selesai, Ditolak)

**Filter & Search:**
- **Search**: Cari berdasarkan nomor aduan atau lokasi
- **Filter Status**: Filter berdasarkan status tertentu
- **Filter Kategori**: Filter berdasarkan kategori aduan
- **Reset**: Bersihkan semua filter

**Pagination:**
- Navigasi dengan tombol "Sebelumnya" dan "Berikutnya"
- Tiap halaman menampilkan 10 aduan

**Aksi:**
- **Detail**: Lihat detail lengkap aduan
- **Ubah Status**: Perbarui status aduan
- **Hapus**: Hapus aduan dari sistem

### 2. Detail Aduan

**Akses:**
- Dari Daftar Aduan → Klik "Detail"

**Informasi yang Ditampilkan:**
- **Status Saat Ini**: Status aduan dengan warna indikator
- **Informasi Aduan**: Tanggal, kategori, lokasi, isi aduan
- **Informasi Pelapor**: Nama, email, nomor telepon masyarakat
- **Riwayat Status**: Timeline perubahan status aduan
- **Tanggapan**: Respons dari pihak yang menangani

**Aksi:**
- **Ubah Status**: Buka modal untuk mengubah status
- **Cetak**: Print detail aduan
- **Hapus**: Hapus aduan

**Cara Ubah Status:**
1. Klik tombol "Ubah Status"
2. Pilih status baru dari dropdown
3. Masukkan keterangan (optional)
4. Klik "Simpan"
5. Status akan berubah dan riwayat terupdate

---

## 📊 Laporan

Dashboard analitik untuk melihat statistik dan trend pengaduan.

**Akses:**
- Menu → Laporan → Laporan Aduan

### Statistik Ringkas
- **Total Aduan**: Total semua aduan sepanjang waktu
- **Hari Ini**: Jumlah aduan yang masuk hari ini
- **Bulan Ini**: Jumlah aduan bulan ini
- **Tahun Ini**: Jumlah aduan tahun ini

### Grafik Analisis
- **Aduan Per Status**: Breakdown jumlah aduan per status dengan grafik bar
- **Aduan Per Kategori**: Breakdown jumlah aduan per kategori dengan grafik bar

### Export Data
- **Export PDF**: Download laporan dalam format PDF
- **Export Excel**: Download laporan dalam format Excel untuk analisis lebih lanjut

---

## ⚙️ Pengaturan Akun

Kelola profil dan keamanan akun pribadi Anda.

**Akses:**
- Menu → Pengaturan → Akun Saya
- Atau klik avatar profil di corner kanan atas

### Tab 1: Profil

**Edit Informasi Pribadi:**
- **Nama Pengguna**: Nama lengkap Anda
- **Email**: Alamat email Anda

**Cara Edit:**
1. Ubah informasi yang ingin diperbarui
2. Klik "Simpan Profil"
3. Data akan terupdate dan Anda akan logout
4. Login kembali dengan email baru (jika diubah)

### Tab 2: Ubah Password

**Updatekan Keamanan Akun:**
1. Masukkan **Password Lama**: Password saat ini
2. Masukkan **Password Baru**: Password minimal 6 karakter
3. Konfirmasi **Password Baru** lagi
4. Klik "Ubah Password"

**Validasi:**
- Password lama harus benar
- Password baru minimal 6 karakter
- Konfirmasi harus cocok dengan password baru

### Tab 3: Pengaturan Sistem

**Notifikasi:**
- ✓ Notifikasi Email: Aktifkan/nonaktifkan notifikasi email
- ✓ Notifikasi SMS: Aktifkan/nonaktifkan notifikasi SMS
- ✓ Notifikasi In-App: Tampilkan notifikasi dalam aplikasi

**Informasi Sistem:**
- Nama Aplikasi
- Versi
- Status (Aktif/Nonaktif)

**Cache & Backup:**
- Clear Cache: Bersihkan cache aplikasi
- Backup Data: Backup data pengguna

**Security:**
- Two-Factor Authentication: Aktifkan 2FA untuk keamanan ekstra
- Delete Account: Hapus akun permanen (hati-hati, tidak bisa dibatalkan)

---

## 🔄 Workflow Aduan

### Lifecycle Aduan

```
DIAJUKAN (Aduan baru masuk)
    ↓
DIVERIFIKASI (Admin memverifikasi data)
    ↓
DIPROSES (OPD/bagian terkait menghandle)
    ↓
SELESAI (Aduan selesai ditangani)

ATAU

    ↓
DITOLAK (Aduan tidak valid)
```

### Sebagai Pelapor (Masyarakat):
1. **Buat Aduan**: Isi form dengan kategori, lokasi, deskripsi masalah
2. **Monitor Status**: Lihat progress di Daftar Aduan
3. **Terima Tanggapan**: Baca tanggapan dari yang menangani

### Sebagai Operator OPD:
1. **Verifikasi Aduan**: Check kelengkapan data aduan
2. **Ubah Status ke Diverifikasi**: Tandai data sudah OK
3. **Proses Aduan**: Ubah status ke Diproses saat mulai handle
4. **Beri Tanggapan**: Berikan update/feedback ke pelapor
5. **Tutup Aduan**: Ubah status ke Selesai

### Sebagai Admin:
1. **Monitor Semua Aduan**: Lihat semua aduan yang masuk
2. **Analisis Data**: Lihat laporan dan statistik
3. **Kelola Master Data**: Update kategori, akses level
4. **Manage Users**: Tambah/edit/hapus pengguna
5. **System Settings**: Konfigurasi pengaturan sistem

---

## 💡 Tips & Best Practices

### Untuk Pengguna:
- Lengkapi data profil Anda untuk komunikasi lebih baik
- Gunakan password yang kuat (kombinasi huruf, angka, simbol)
- Segera ubah password default setelah pertama kali login
- Monitor status aduan Anda secara berkala

### Untuk Admin:
- Backup data secara regular
- Update master data sesuai kebutuhan
- Monitoring laporan untuk analisis trend
- Kelola user dengan hak akses sesuai peran

### Untuk OPD Operator:
- Verifikasi aduan dengan hati-hati
- Berikan tanggapan yang jelas dan profesional
- Update status secara real-time
- Archive aduan yang sudah selesai

---

## ❓ FAQ

**Q: Saya lupa password, bagaimana?**
A: Hubungi admin untuk reset password

**Q: Bagaimana cara lihat semua aduan saya?**
A: Menu → Manajemen Aduan → Daftar Aduan

**Q: Berapa lama aduan diproses?**
A: Tergantung jenis aduan, biasanya 1-7 hari kerja

**Q: Apakah data saya aman?**
A: Ya, sistem menggunakan enkripsi dan akses control

**Q: Bagaimana jika ada error atau bug?**
A: Hubungi IT support atau screenshot dan laporkan

---

## 📞 Contact & Support

Untuk pertanyaan dan dukungan teknis:
- **Email Support**: support@elapor.local
- **Hotline**: (021) XXXX-XXXX
- **Jam Kerja**: Senin-Jumat, 08:00-17:00

---

**Last Updated**: 2024
**Version**: 1.0.0
