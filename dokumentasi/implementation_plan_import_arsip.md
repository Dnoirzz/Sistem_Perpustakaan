# Rencana Implementasi: Fitur Import Data Arsip Digital Via Excel / CSV (Petugas)

Fitur ini memungkinkan Petugas Perpustakaan untuk menambahkan data arsip digital mahasiswa secara massal menggunakan file Excel (.xlsx, .xls) atau CSV (.csv). Fitur ini membantu pencatatan data historis (alumni) dari tahun-tahun sebelumnya secara efisien.

## User Review Required

> [!IMPORTANT]
> **Penulisan Akun Alumni Otomatis (Auto-Create):**
> Jika NIM mahasiswa yang di-import dari Excel belum terdaftar di database, sistem akan secara otomatis membuatkan akun `user` dan profil `mahasiswa` dummy (alumni) baru agar relasi database tetap utuh. Sistem akan mencocokkan nama **Program Studi** di Excel dengan data prodi di database. Jika Program Studi tidak cocok dengan daftar prodi yang terdaftar di database, proses import dibatalkan.

> [!IMPORTANT]
> **Alur Logika Jenis Arsip Pilihan:**
> Petugas akan memilih jenis arsip yang ingin di-import terlebih dahulu melalui dropdown select di halaman import (Laporan PKL, Proposal TA, atau Laporan TA). Link "Unduh Template" dan proses validasi di backend akan menyesuaikan secara dinamis dengan jenis arsip yang dipilih (misal: kolom "Tempat PKL" hanya ada dan wajib diisi jika meng-import Laporan PKL).

> [!IMPORTANT]
> **Penanganan Duplikat (Abaikan / Skip):**
> Sistem mendeteksi duplikasi berdasarkan kombinasi **NIM Mahasiswa + Tipe Arsip yang di-import**. Karena mahasiswa hanya boleh memiliki satu arsip untuk masing-masing tipe, jika mahasiswa tersebut sudah memiliki tipe arsip terpilih di database, baris data tersebut dilewati (skip) secara otomatis untuk menghindari penumpukan data ganda atau kesalahan import berulang.

> [!NOTE]
> **Sinkronisasi Koleksi Fisik:**
> Karena status arsip yang di-import disetel sebagai **Aktif** (arsip fisik/buku cetak dan CD sudah diserahkan), sistem akan membuat entri di tabel `collections` secara otomatis dengan `stock = 1` agar dapat digunakan dalam transaksi fisik.

---

## Proposed Changes

### Backend Route & Controller

#### [MODIFY] [web.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/routes/web.php)
Menambahkan rute-rute berikut di dalam grup petugas (`role:petugas`):
*   `GET /petugas/arsip-import` -> `ArsipController@showImportForm` (`petugas.arsip.import.form`)
*   `POST /petugas/arsip-import` -> `ArsipController@import` (`petugas.arsip.import`)
*   `GET /petugas/arsip-import/download-template` -> `ArsipController@downloadTemplate` (`petugas.arsip.import.template`)

#### [MODIFY] [ArsipController.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/app/Http/Controllers/Petugas/ArsipController.php)
Menambahkan metode:
1.  `showImportForm()`: Menampilkan view `petugas.arsip.import`.
2.  `downloadTemplate(Request $request)`: Menerima parameter `type` (`laporan-pkl`, `proposal-ta`, `laporan-ta`). Membuat template Excel khusus untuk tipe terpilih.
    *   *Laporan PKL:* No Arsip, NIM, Nama Mahasiswa, Program Studi, Judul, Tempat PKL, Pembimbing, Penguji 1, Penguji 2, Tahun
    *   *Proposal TA / Laporan TA:* No Arsip, NIM, Nama Mahasiswa, Program Studi, Judul, Pembimbing, Penguji 1, Penguji 2, Tahun
3.  `import(Request $request)`:
    *   Validasi `type` (harus `laporan-pkl`, `proposal-ta`, atau `laporan-ta`) dan berkas file.
    *   Membaca baris data Excel secara transaksional (`DB::beginTransaction()`).
    *   Untuk setiap baris:
        *   Cari mahasiswa berdasarkan NIM. Jika tidak ada, cari data Program Studi di database. Jika prodi ditemukan, buat user & mahasiswa baru (alumni) secara otomatis di background.
        *   Validasi data: Judul wajib, Tahun wajib (integer), Tempat PKL wajib khusus PKL.
        *   Cek duplikasi: Jika mahasiswa sudah memiliki arsip dengan tipe terpilih, lewati (skip).
        *   Simpan ke database (ke tabel `laporan_pkl`, `proposal_ta`, atau `laporan_tugas_akhir`).
        *   Buat entri di tabel `collections` dengan `stock = 1` karena status di-set sebagai `aktif`.
    *   Catat ke `ActivityLog`.

---

### Frontend Views & UI Design

#### [MODIFY] [index.blade.php (Arsip)](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/petugas/arsip/index.blade.php)
*   Menambahkan tombol **"Import Excel Arsip"** berwarna hijau premium (`bg-emerald-600`) di bagian atas tabel.

#### [NEW] [import.blade.php (Arsip)](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/petugas/arsip/import.blade.php)
*   Membuat halaman form upload dengan **Dropdown Select Jenis Arsip** (PKL, Proposal TA, Laporan TA). 
*   Petugas memilih jenis arsip terlebih dahulu. JavaScript akan memperbarui link "Unduh Template" secara dinamis berdasarkan pilihan tersebut agar petugas mendapatkan file template yang sesuai.
*   Menyediakan drag & drop zone dan kotak penanganan error baris yang informatif.

---

## Verification Plan

### Automated Tests
*   `php -l app/Http/Controllers/Petugas/ArsipController.php`
*   `php artisan view:cache`

### Manual Verification
1.  Buka form import arsip, pilih tipe "Laporan PKL", lalu klik "Unduh Template". Pastikan file terunduh memuat kolom "Tempat PKL".
2.  Pilih tipe "Laporan TA", klik "Unduh Template", pastikan kolom "Tempat PKL" tidak ada.
3.  Uji import arsip dengan NIM alumni baru yang belum terdaftar. Pastikan sistem otomatis membuat akun mahasiswa dummy dengan prodi yang cocok, dan arsip tersimpan aktif dengan entri `collections` bernilai `stock = 1`.
4.  Uji import ulang berkas yang sama untuk memverifikasi duplikasi berhasil di-skip tanpa error.
