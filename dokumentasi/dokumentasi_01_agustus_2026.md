# Dokumentasi Perkembangan Sistem Perpustakaan Digital (SIPUS POLNEP)
**Tanggal**: 01 Agustus 2026  
**Lokasi Repository**: PSDKU POLNEP Sukamara  

---

## 📋 Ringkasan Perubahan & Fitur Baru

### 1. 🔔 Sistem Notifikasi & Badge Tugas Pending Petugas
- **Pembaruan Badge Notifikasi**:
  - Menambahkan badge notifikasi berwarna merah pada menu sidebar Petugas untuk memberitahukan tugas-tugas yang memerlukan tindakan segera (Peminjaman Pending, Pengembalian Pending, dan Permohonan Surat Bebas Pustaka Pending).
  - Badge menampilkan total angka real-time dari jumlah transaksi yang harus diproses.

---

### 2. 📘 Cover Bawaan Buku (Default Cover Logo POLNEP)
- **Terpusat pada Model `Book.php`**:
  - Mengimplementasikan method `$book->cover_url` pada model `Book.php`.
  - Secara otomatis mendeteksi ketersediaan gambar di storage. Jika belum diunggah/kosong, otomatis mengembalikan URL `asset('img/logo_polnep.webp')`.
- **Tampilan Bersih & Edisi Resmi**:
  - Semua katalog buku (Landing Page, Katalog Mahasiswa, Katalog Dosen, dan Tabel Petugas) menampilkan gambar logo POLNEP secara rapi di tengah kontainer berlatar putih bersih (`bg-white` & `object-contain p-6`).

---

### 3. 🎓 Landing Page 2 Section (Buku Teks & Repositori Karya Ilmiah)
- **Pemisahan Section Koleksi (`welcome.blade.php`)**:
  - **Section 1: 📚 Koleksi Buku Terbaru**  
    Menampilkan 5 buku teks/cetak umum terbaru dengan tombol *"Pinjam"*.
  - **Section 2: 🎓 Karya Ilmiah Mahasiswa (Repositori Digital)**  
    Menampilkan 5 karya ilmiah digital terbaru (diprioritaskan **Laporan Tugas Akhir**, dilanjutkan Proposal TA / Laporan PKL).
- **Filter Validasi Publikasi**:
  - Hanya menampilkan karya ilmiah yang berstatus **`aktif`** dan file PDF-nya **sudah diunggah** (`file_pdf` not null & not empty).
- **Penanganan Judul Presisi (`\App\Support\ArsipDigital::title()`)**:
  - Menggunakan helper `ArsipDigital::title($item)` pada controller/route untuk menangani perbedaan nama kolom database (`judul_tgs_akhir`, `judul_proposal`, dan `judul_pkl`) sehingga judul tampil 100% sempurna di beranda.
- **Navigasi Menu Utama**:
  - Menambahkan menu navigasi **"Karya Ilmiah"** (`#repositori`) pada Top NavBar Desktop, Mobile Drawer Menu, dan Footer untuk akses cepat ke section repositori digital.

---

### 4. 🔒 Penguncian Redirect Login ke Dashboard
- **Kontrol Alur Login (`AuthenticatedSessionController.php`)**:
  - Memastikan proses autentikasi login selalu mengarahkan pengguna secara konsisten & langsung ke `route('dashboard')` sesuai role masing-masing (Mahasiswa, Dosen, Petugas, atau Admin).

---

## 🛠️ File-File yang Dimodifikasi

1. [routes/web.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/routes/web.php)
2. [app/Models/Book.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/app/Models/Book.php)
3. [app/Http/Controllers/Auth/AuthenticatedSessionController.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/app/Http/Controllers/Auth/AuthenticatedSessionController.php)
4. [resources/views/welcome.blade.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/welcome.blade.php)
5. [resources/views/mahasiswa/books/index.blade.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/mahasiswa/books/index.blade.php)
6. [resources/views/dosen/books/index.blade.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/dosen/books/index.blade.php)
7. [resources/views/petugas/books/index.blade.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/petugas/books/index.blade.php)
8. [dokumentasi/dokumentasi_01_agustus_2026.md](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/dokumentasi/dokumentasi_01_agustus_2026.md)

---
*Dokumentasi disusun secara otomatis pada 01 Agustus 2026.*
