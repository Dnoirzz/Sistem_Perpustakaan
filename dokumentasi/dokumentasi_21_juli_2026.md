# Dokumentasi Pembaruan Sistem (21 Juli 2026)

Dokumen ini mencatat seluruh pembaruan, perbaikan, dan fitur baru yang telah diimplementasikan pada aplikasi **SIPUS (Sistem Informasi Perpustakaan) PSDKU POLNEP** pada tanggal 21 Juli 2026.

---

## 1. Fitur Import Data Arsip Digital via Excel (Petugas)
*   **Implementasi Utama**: Menambahkan fitur untuk mengimpor data arsip mahasiswa secara massal untuk 3 kategori: Laporan PKL, Proposal Tugas Akhir (TA), dan Laporan Tugas Akhir (TA).
*   **Kolom Baru (Nomor Surat Tanda Terima)**: Menambahkan kolom pertama di berkas Excel untuk mencatat Nomor Surat Tanda Terima secara dinamis.
*   **Auto-Formatting Nomor Surat**: 
    *   Jika nomor surat diinput sebagai angka sederhana (misal: `24` atau `024`), sistem secara otomatis merangkainya dengan format resmi perpustakaan dari pengaturan admin (`AppSetting::get('receipt_kode_surat')`) dan tahun terbit terkait (contoh menjadi: `024/PL.16.A3/KM/2026`).
    *   Jika diinput secara manual dengan teks lengkap, data disimpan apa adanya.
*   **Validasi Keunikan & Proteksi**: 
    *   Memvalidasi keunikan Nomor Surat dan keunikan NIM + Tipe Arsip sebelum disimpan ke database.
    *   Jika terdeteksi duplikasi, baris data tersebut akan dilewati (*skip*).
*   **Alur Otomatisasi Terkait**:
    *   **Akun Alumni**: Jika NIM mahasiswa belum terdaftar, sistem otomatis membuatkan akun alumni dummy berstatus 'Alumni' dengan password standar `sipus[NIM]`.
    *   **Koleksi Fisik**: Data yang masuk otomatis terdaftar di tabel `collections` dengan stok fisik default = 1 dan berstatus aktif.

---

## 2. Pop-up Dialog Konfirmasi Kustom (`SIPUSModal`)
*   **Desain Modern**: Menggantikan dialog konfirmasi standard browser (`confirm()`) dengan modal dialog kustom bertema SIPUS perpustakaan yang interaktif (animasi *scale/fade*, *glassmorphism backdrop*, serta ikon visual).
*   **Penerapan Global (Interceptor)**:
    *   Dibuat pada berkas partial [custom-confirm.blade.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/layouts/custom-confirm.blade.php).
    *   Dilengkapi script berbasis `MutationObserver` yang secara otomatis menghadang seluruh elemen `<form>` yang memakai atribut `onsubmit="return confirm(...)"` di seluruh sistem secara asinkron tanpa merusak kode bawaan lainnya.
*   **Multi-Role Integration**: Berkas disematkan di bagian bawah sidebar peran **Admin**, **Petugas**, **Mahasiswa**, dan **Dosen**.
*   **Graceful PDF Handling**:
    *   Menambahkan logika pengkondisian di detail katalog: Jika data arsip tidak memiliki berkas digital (karena di-import dari Excel), tombol "Baca Dokumen Lengkap (PDF)" diubah secara visual menjadi tombol non-aktif abu-abu berikon gembok bertuliskan *"Berkas Digital Belum Diunggah (Hanya tersedia koleksi fisik)"*. Ini mencegah terjadinya error 404 pada browser.

---

## 3. Fitur Import Data Buku Umum via Excel (Petugas)
*   **Penyuntingan Rute & Controller**:
    *   Menambahkan rute-rute baru di [web.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/routes/web.php).
    *   Mengimplementasikan fungsi `showImportForm`, `downloadTemplate`, dan `import` di `BookController`.
*   **Format Template Excel**: Membuat template Excel (`template_import_buku.xlsx`) dengan 6 kolom utama: *Judul Buku, Penulis/Pengarang, Penerbit, Tahun Terbit, Stok, Kategori*.
*   **Validasi Transaksional**: Proses import menggunakan `DB::beginTransaction()`. Jika ada satu baris yang tidak lolos validasi (format stok negatif, tahun tidak valid, kolom wajib kosong), operasi dibatalkan seluruhnya (*rollback*) dan sistem menampilkan daftar pesan error detail per baris.
*   **Penanganan Duplikasi & Kategori Baru**:
    *   Jika kombinasi Judul Buku + Penulis sudah ada di database, baris tersebut dilewati (*skip*).
    *   Jika kategori buku belum terdaftar di sistem, sistem otomatis membuat Kategori baru (*case-insensitive*).
    *   Penyimpanan entri buku baru otomatis menyinkronkan data stok ke tabel `collections` (koleksi fisik buku).
*   **Penyuntingan View**:
    *   Menambahkan tombol **"Import Excel"** hijau di halaman kelola buku.
    *   Membuat view [import.blade.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/petugas/books/import.blade.php) yang dilengkapi fitur interaktif drag & drop file.

---

## 4. Perbaikan Bug Tampilan Tombol Impor (Bug Fix)
*   **Masalah**: Warna tombol "Import Excel" dan tombol unduh template tidak muncul (menjadi transparan dengan teks putih) di beberapa halaman import.
*   **Penyebab**: Penggunaan kelas Tailwind CSS `bg-emerald-650` dan `shadow-emerald-650/20` yang tidak valid (tidak terdaftar pada standar palet warna Tailwind).
*   **Solusi**: Memperbaiki seluruh kemunculan kelas tersebut menjadi **`bg-emerald-600`** dan **`shadow-emerald-600/20`** pada berkas berikut:
    *   Tombol Import Halaman Buku: [index.blade.php (Buku)](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/petugas/books/index.blade.php)
    *   Halaman Form Buku: [import.blade.php (Buku)](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/petugas/books/import.blade.php)
    *   Halaman Form Arsip: [import.blade.php (Arsip)](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/petugas/arsip/import.blade.php)
    *   Halaman Form Pengguna Admin: [import.blade.php (User Admin)](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/admin/users/import.blade.php)
