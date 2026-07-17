# Rencana Implementasi: Fitur Import User / Anggota Via Excel (Admin)

Fitur ini memungkinkan Administrator untuk menambahkan data akun pengguna (Mahasiswa & Dosen) secara massal menggunakan file Excel (.xlsx, .xls) atau CSV (.csv). Fitur ini mempercepat pendaftaran anggota baru (misal: saat tahun ajaran baru) secara efisien tanpa harus menginput satu per satu.

## Desain Logika Akun Otomatis (Email & Password Template)

> [!NOTE]
> **Skema Pembuatan Akun Otomatis:**
> Untuk mempermudah proses pengisian berkas Excel, Admin tidak perlu menuliskan kolom Email dan Password di Excel. Sistem akan membuatkannya secara otomatis berdasarkan NIM/NIP yang dimasukkan:
> *   **Format Email:** `[NIM/NIP]@sipus.polnep.ac.id` (contoh: `3202316109@sipus.polnep.ac.id`)
> *   **Format Password:** `sipus[NIM/NIP]` (contoh: `sipus3202316109`)
> Petunjuk pembuatan otomatis ini akan ditampilkan dengan jelas di halaman form upload dan di dalam berkas template Excel agar Admin dan Pengguna mengetahui kredensial awal mereka. Pengguna dapat mengubah email dan password mereka secara mandiri setelah berhasil masuk ke halaman profil.

## User Review Required

> [!IMPORTANT]
> **Penanganan Duplikat (Abaikan / Skip):**
> Sistem mendeteksi duplikasi berdasarkan **NIM** (untuk Mahasiswa) atau **NIP** (untuk Dosen). Jika NIM atau NIP tersebut sudah terdaftar di database, baris data tersebut akan **dilewati (skip)** secara otomatis untuk mencegah kegagalan proses import atau duplikasi akun ganda yang salah.

> [!IMPORTANT]
> **Pencocokan Program Studi:**
> Sistem mencocokkan nama **Program Studi** di Excel dengan data prodi di database secara case-insensitive. Jika nama Program Studi di Excel tidak cocok dengan yang ada di database, baris tersebut akan memicu kesalahan validasi dan proses import dibatalkan.

> [!NOTE]
> **Deteksi Peran Otomatis (Mahasiswa vs Dosen):**
> Sistem akan mendeteksi peran pengguna secara otomatis berdasarkan isi kolom **Semester**:
> *   Jika kolom **Semester** diisi (misal: "Semester 1", "3", "6", dll.), maka sistem mendaftarkannya sebagai **Mahasiswa**.
> *   Jika kolom **Semester** dikosongkan (null/empty), maka sistem mendaftarkannya sebagai **Dosen**.

---

## Proposed Changes

### Backend Route & Controller

#### [MODIFY] [web.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/routes/web.php)
Menambahkan rute-rute berikut di dalam grup middleware admin (`role:admin`) di bawah pengelolaan users:
*   `GET /admin/users-import` -> `UserController@showImportForm` (`admin.users.import.form`)
*   `POST /admin/users-import` -> `UserController@import` (`admin.users.import`)
*   `GET /admin/users-import/download-template` -> `UserController@downloadTemplate` (`admin.users.import.template`)

#### [MODIFY] [UserController.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/app/Http/Controllers/Admin/UserController.php)
Menambahkan metode:
1.  `showImportForm()`: Menampilkan view `admin.users.import`.
2.  `downloadTemplate()`: Membuat template Excel terformat menggunakan `PhpOffice\PhpSpreadsheet` (Kolom: Nama Lengkap, NIM / NIP, Jurusan, Program Studi, Semester) lengkap dengan contoh baris mahasiswa & dosen serta teks panduan di bagian atas.
3.  `import(Request $request)`:
    *   Validasi file (xlsx, xls, csv, maks 10MB).
    *   Membaca baris data Excel secara transaksional (`DB::beginTransaction()`).
    *   Untuk setiap baris:
        *   Validasi data: Nama Lengkap, NIM / NIP, Jurusan, dan Program Studi wajib diisi.
        *   Deteksi peran: Jika kolom Semester diisi, peran = `mahasiswa`. Jika kosong, peran = `dosen`.
        *   Cari Role ID dan Prodi ID berdasarkan nama Program Studi di database.
        *   Cek keunikan NIM/NIP di database. Jika sudah ada, lewati (skip).
        *   Buat user baru dengan password yang telah di-hash (`sipus[NIM/NIP]`) dan email template (`[NIM/NIP]@sipus.polnep.ac.id`).
        *   Buat entri profil di tabel `mahasiswas` atau `dosens` sesuai peran terpilih.
    *   Catat ke `ActivityLog` dan komit transaksi.

---

### Frontend Views & UI Design

#### [MODIFY] [index.blade.php (Users)](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/admin/users/index.blade.php)
*   Menambahkan tombol **"Import Excel"** berwarna hijau premium (`bg-emerald-600`) dengan ikon `upload_file` di sebelah kiri tombol "Tambah User".

#### [NEW] [import.blade.php (Users)](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/admin/users/import.blade.php)
*   Membuat halaman form upload untuk import user dengan desain premium (card putih rounded-3xl, link download template, drag & drop zone berkas, kotak panduan format email/password template, dan penanganan detail list error baris jika proses gagal).

---

## Verification Plan

### Automated Tests
*   `php -l app/Http/Controllers/Admin/UserController.php`
*   `php artisan view:cache`

### Manual Verification
1.  Buka menu **Kelola User** Admin, pastikan tombol **Import Excel** muncul.
2.  Klik tombol, unduh berkas template Excel, isi dengan data yang valid dan tidak valid.
3.  Uji import dengan data tidak valid (peran salah, prodi fiktif) untuk memastikan database aman (rollback) dan error baris tampil jelas.
4.  Uji import dengan data mahasiswa & dosen valid. Pastikan akun berhasil terbuat di database dengan email template (`[NIM/NIP]@sipus.polnep.ac.id`) dan password terenkripsi.
5.  Uji coba login menggunakan kredensial email & password template hasil import tersebut untuk memastikan kecocokannya.
6.  Uji import ulang berkas yang sama untuk memverifikasi duplikasi berhasil di-skip tanpa error.
