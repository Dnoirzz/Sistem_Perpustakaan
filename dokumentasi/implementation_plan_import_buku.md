# Rencana Implementasi: Fitur Import Data Buku Umum Via Excel / CSV (Petugas)

Fitur ini memungkinkan Petugas Perpustakaan untuk menambahkan data buku secara massal menggunakan file Excel (.xlsx, .xls) atau CSV (.csv). Fitur ini bertujuan mempercepat pencatatan inventaris buku masal.

## User Review Required

> [!IMPORTANT]
> **Penanganan Buku Duplikat (Abaikan / Skip):**
> Sistem akan mendeteksi duplikasi berdasarkan kombinasi **Judul + Penulis** (secara case-insensitive). Jika buku dengan kombinasi tersebut sudah ada di database, baris data tersebut akan **dilewati (skip)** secara otomatis untuk menghindari penumpukan data ganda atau pengakumulasian stok secara keliru akibat kesalahan import berulang.

> [!IMPORTANT]
> **Skema Validasi & Alur Transaksional:**
> Proses import bersifat transaksional (`DB::beginTransaction()`). Jika terdapat satu saja baris data yang tidak valid (misal: stok negatif, tahun terbit di luar rentang, atau kolom wajib kosong), seluruh proses import akan dibatalkan (rollback) dan sistem menampilkan daftar detail kesalahan per baris.

> [!NOTE]
> **Pencocokan Kategori Otomatis:**
> Sistem akan mencari kategori berdasarkan nama secara case-insensitive. Jika kategori tersebut belum ada di sistem, kategori baru akan dibuat otomatis.

---

## Proposed Changes

### Backend Route & Controller

#### [MODIFY] [web.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/routes/web.php)
Menambahkan rute-rute berikut di dalam grup petugas (`role:petugas`):
*   `GET /petugas/books-import` -> `BookController@showImportForm` (`petugas.books.import.form`)
*   `POST /petugas/books-import` -> `BookController@import` (`petugas.books.import`)
*   `GET /petugas/books-import/download-template` -> `BookController@downloadTemplate` (`petugas.books.import.template`)

#### [MODIFY] [BookController.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/app/Http/Controllers/Petugas/BookController.php)
Menambahkan metode:
1.  `showImportForm()`: Menampilkan view `petugas.books.import`.
2.  `downloadTemplate()`: Membuat template Excel terformat menggunakan `PhpOffice\PhpSpreadsheet` (Kolom: Judul Buku, Penulis / Pengarang, Penerbit, Tahun Terbit, Stok, Kategori) dan menyajikannya sebagai unduhan langsung.
3.  `import(Request $request)`:
    *   Validasi file (xlsx, xls, csv, maks 10MB).
    *   Membaca baris sheet Excel/CSV dengan `PhpOffice\PhpSpreadsheet\IOFactory`.
    *   Mencocokkan baris header secara fleksibel (case-insensitive) untuk mendeteksi kolom: **Judul**, **Penulis**, **Penerbit**, **Tahun Terbit**, **Stok**, **Kategori**.
    *   Validasi data baris demi baris secara transaksional (`DB::beginTransaction()`).
    *   Deteksi duplikasi (Judul + Penulis). Jika ada, lewati (skip).
    *   Cari/buat kategori secara case-insensitive, simpan buku baru via `Book::create()`.
    *   Catat log aktivitas ke `ActivityLog` dan komit transaksi.

---

### Frontend Views & UI Design

#### [MODIFY] [index.blade.php (Books)](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/petugas/books/index.blade.php)
*   Menambahkan tombol **"Import Excel"** berwarna hijau premium (`bg-emerald-600`) dengan ikon `upload_file` di sebelah kiri tombol "Tambah Buku Baru".

#### [NEW] [import.blade.php (Books)](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/petugas/books/import.blade.php)
*   Membuat halaman form upload untuk import buku lengkap dengan drag & drop zone, petunjuk pengisian, link unduh template, dan kotak penanganan error baris yang transparan.

---

## Verification Plan

### Automated Tests
*   `php -l app/Http/Controllers/Petugas/BookController.php`
*   `php artisan view:cache`

### Manual Verification
1.  Buka halaman **Kelola Buku** dan pastikan tombol **Import Excel** muncul dengan rapi.
2.  Klik tombol **Import Excel**, unduh berkas template, pastikan kolomnya sesuai.
3.  Uji import buku dengan data tidak valid (stok negatif, tahun terbit tidak valid) untuk memastikan database di-rollback utuh dan memicu tampilan error baris yang jelas.
4.  Uji import dengan data valid. Pastikan buku berhasil disimpan dan data di tabel `collections` terbuat secara otomatis.
5.  Uji import ulang berkas yang sama untuk memverifikasi duplikasi berhasil di-skip tanpa error.
