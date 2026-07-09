# Laporan & Dokumentasi Perkembangan Harian 📚

**Hari/Tanggal:** Selasa, 2 Juni 2026  
**Project:** Aplikasi Perpustakaan PSDKU POLNEP Sukamara  
**Fokus Utama:** Penyelesaian Fase 3 (Manajemen Data) & Penyesuaian Visual/Fungsional Khusus

---

## 🛠️ Ringkasan Fitur & Perubahan yang Diselesaikan Hari Ini

### 1. Fase 3: Manajemen Data Perpustakaan (Selesai Sepenuhnya) ✅
Seluruh fitur pengelolaan data pustaka, kategori, keanggotaan, serta katalog pencarian buku selesai diimplementasikan dengan standar keamanan tinggi dan UI premium:

*   **CRUD Buku & Kategori (Petugas)**:
    *   **Eloquent Observer Sync**: Sinkronisasi otomatis data Buku ke tabel `collections` (polimorfik manual) untuk mempermudah alur transaksi di Fase 4.
    *   **Unggah Gambar & Validasi**: Mendukung pengunggahan cover buku dengan nama berkas aman, validasi ukuran maksimal 2MB, dan pembersihan otomatis (hapus cover lama) dari storage saat buku diedit atau dihapus.
    *   **Interactive Preview**: Preview gambar cover muncul secara instan begitu file dipilih menggunakan `FileReader` API.
*   **CRUD Anggota (Petugas)**:
    *   **Keamanan & Batasan Peran**: Membatasi petugas agar hanya dapat mengelola akun **Mahasiswa** dan **Dosen**. Percobaan URL bypass untuk mengedit Admin/Petugas dikunci secara ketat dan menghasilkan respon `403 Forbidden`.
    *   **Form Dinamis Alpine.js**: Input form memuat field dinamis sesuai jenis keanggotaan (kolom NIM & Semester untuk Mahasiswa, kolom NIP untuk Dosen).
*   **Katalog Pencarian Buku (Mahasiswa & Dosen)**:
    *   **BookSearchController Terpusat**: Memproses pencarian buku (judul, penulis, penerbit) dan filter kategori.
    *   **UI Grid Kartu Premium**: Visualisasi modern menggunakan grid card lengkap dengan info cover, status ketersediaan dinamis ("Tersedia ([Stok] eks)" / "Habis"), serta tombol pintas "Booking" dan "Antri" yang siap dihubungkan ke modul transaksi.

---

### 2. Penyesuaian Fungsional & Estetika (Berdasarkan Umpan Balik) ⚙️

*   **Pelebaran Container Form**:
    *   Mengubah ukuran container dari `max-w-4xl` (896px) menjadi `max-w-6xl` (1152px) pada 4 file view petugas agar form input memiliki ruang bernapas yang lebih luas dan teks placeholder tidak terpotong (misal pada kolom Penerbit, Tahun Terbit, Stok).
    *   *Berkas yang dimodifikasi:*
        *   [create.blade.php (Books)](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/petugas/books/create.blade.php)
        *   [edit.blade.php (Books)](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/petugas/books/edit.blade.php)
        *   [create.blade.php (Members)](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/petugas/members/create.blade.php)
        *   [edit.blade.php (Members)](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/petugas/members/edit.blade.php)

*   **Kolom "Dipinjam" pada Kelola Buku**:
    *   Menambahkan kolom baru **"Dipinjam"** di antara kolom "Stok" dan "Aksi" pada tabel kelola buku petugas agar petugas tahu berapa banyak copy buku yang sedang aktif dipinjam.
    *   Menggunakan accessor `active_loans_count` di model `Book` untuk menghitung relasi `Loan` dengan status `'dipinjam'`.
    *   Mengoptimalkan kueri dengan eager-loading relasi `collection` di `BookController` guna menghindari masalah N+1 query.
    *   *Berkas yang dimodifikasi:*
        *   [Book.php (Model)](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/app/Models/Book.php)
        *   [BookController.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/app/Http/Controllers/Petugas/BookController.php)
        *   [index.blade.php (Books)](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/petugas/books/index.blade.php)

*   **Proteksi Perubahan Jenis Keanggotaan (Role) Saat Edit**:
    *   Menonaktifkan dropdown pemilihan role pada halaman edit anggota. Dropdown diganti dengan **Badge Kategori Read-only** yang menunjukkan jenis keanggotaan saat ini dan bertuliskan "Tidak dapat diubah". Nilai aslinya tetap dikirim via hidden input.
    *   Mengamankan sisi backend pada `MemberController@update` agar `role_id` dikunci sesuai data asli dari database (mengabaikan input manipulasi request) serta menghapus logika transisi/migrasi profil lama yang sudah tidak diperlukan.
    *   *Berkas yang dimodifikasi:*
        *   [edit.blade.php (Members)](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/petugas/members/edit.blade.php)
        *   [MemberController.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/app/Http/Controllers/Petugas/MemberController.php)

---

## 📂 Lokasi Penyimpanan Progress
Seluruh pelacakan tugas dan dokumentasi perkembangan hari ini telah disimpan dengan rapi pada direktori baru:
1.  **Daftar Tugas Terkini:** [task.md](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/dokumentasi/task.md)
2.  **Laporan Harian:** [dokumentasi_harian.md](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/dokumentasi/dokumentasi_harian.md)

---

## Progress Lanjutan Fase 4: Modul Peminjaman Buku

**Hari/Tanggal:** Rabu, 3 Juni 2026  
**Fokus:** Implementasi modul transaksi peminjaman buku untuk petugas dengan gaya UI yang konsisten terhadap halaman operasional yang sudah ada.

### Fitur yang Diselesaikan ✅

*   **Halaman Daftar Transaksi Peminjaman (Petugas)**:
    *   Menambahkan halaman `petugas.loans.index` berisi ringkasan statistik transaksi, pencarian anggota/judul buku, filter status, dan tabel sirkulasi peminjaman.
    *   Pola visual mengikuti halaman petugas yang sudah ada: sidebar tetap, header ringkas, kartu statistik, filter card putih rounded, dan tabel data premium.

*   **Halaman Form Peminjaman Baru**:
    *   Menambahkan halaman `petugas.loans.create` untuk memilih anggota, buku tersedia, tanggal pinjam, dan batas waktu pengembalian.
    *   Form memakai bahasa visual yang sama dengan modul buku dan anggota: card putih, radius besar, tipografi `Outfit` + `Inter`, serta panel bantuan di sisi kanan.

*   **Logika Backend Peminjaman**:
    *   Menambahkan `LoanController` untuk menangani daftar transaksi, tampilan form create, dan proses simpan transaksi baru.
    *   Validasi dibatasi hanya untuk anggota **Mahasiswa** dan **Dosen**.
    *   Sistem menolak peminjaman jika stok buku habis.
    *   Sistem menolak peminjaman duplikat apabila anggota masih memiliki pinjaman aktif untuk judul yang sama.
    *   Stok pada tabel `books` dan `collections` berkurang otomatis setelah transaksi berhasil disimpan.

*   **Sinkronisasi Status Terlambat**:
    *   Menambahkan helper `Loan::syncOverdueStatuses()` agar pinjaman yang melewati batas waktu otomatis berubah status menjadi `terlambat` saat halaman utama transaksi/dashboard diakses.
    *   Sinkronisasi ini dipakai pada dashboard petugas, mahasiswa, dosen, dan halaman daftar peminjaman.

*   **Perapian Helper Koleksi**:
    *   Menambahkan helper tampilan pada model `Collection` untuk judul item dan label jenis koleksi.
    *   View dashboard diperbarui agar tidak lagi bergantung pada relasi `collectable` yang belum selaras dengan struktur model saat ini.

---

## Progress Lanjutan Fase 4: Operasional Sirkulasi & Otomatisasi Transaksi

**Hari/Tanggal:** Kamis, 4 Juni 2026  
**Fokus:** Penyelesaian dan integrasi seluruh fitur Fase 4 (Pengembalian, Denda, Antrian, Booking) serta optimalisasi alur sirkulasi reservasi stok dan penyesuaian visual.

### Fitur & Perbaikan yang Diselesaikan ✅

*   **Penyelesaian Modul Fase 4 (Transaksi)**:
    *   **Pengembalian Buku (Returns)**: Integrasi form dan logika pengembalian. Sistem otomatis mengkalkulasi hari keterlambatan, mencatat denda keterlambatan (Rp 1.000/hari), menaikkan stok buku, dan memperbarui antrean secara otomatis.
    *   **Sistem Antrian (Queue)**: Dashboard antrean petugas dan daftar antrean pribadi mahasiswa/dosen. Menangani pembaruan status antrean menjadi "tersedia" secara otomatis begitu buku terkait dikembalikan.
    *   **Manajemen Denda & Sanksi (Penalties)**: Perhitungan denda otomatis karena keterlambatan, form pencatatan denda manual (kasus buku rusak/hilang), serta aksi tandai lunas oleh petugas.
    *   **Booking Online**: Integrasi dashboard kelola booking masuk dengan tombol persetujuan, penolakan, dan realisasi.

*   **Pembaruan & Optimalisasi Fungsional Lanjutan**:
    *   **Shared Sidebar Component (Petugas)**: Menyatukan seluruh sidebar statis pada 16 halaman view petugas ke dalam satu berkas terpusat [sidebar.blade.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/petugas/layouts/sidebar.blade.php) untuk menjaga konsistensi tautan menu dan sorot menu aktif.
    *   **Realisasi Booking Langsung**: Tombol "Proses Pinjam" pada booking disetujui langsung membuat data peminjaman aktif tanpa perlu menginput ulang data anggota/buku.
    *   **Pembatalan Booking (Manual & Otomatis)**:
        *   Tombol "Batalkan" ditambahkan untuk membatalkan booking berstatus "Disetujui" secara manual dengan disertai alasan.
        *   Otomatisasi pembatalan booking (`Booking::checkExpiredBookings()`) yang berjalan secara dinamis ketika halaman daftar booking/pencarian diakses oleh petugas maupun anggota jika jam batas pengambilan sudah terlewati.
    *   **Reservasi Stok Buku Terintegrasi**:
        *   Mengurangi stok buku langsung saat booking disetujui (direservasi) agar buku tidak dipinjam oleh orang lain.
        *   Mengembalikan stok buku (+1) jika booking dibatalkan secara manual maupun kedaluwarsa otomatis.
        *   Membebaskan proses realisasi pinjam dari pengurangan stok ganda.
    *   **Dropdown Pemilihan Jam Kustom (Format 24 Jam)**:
        *   Mengganti pemilih waktu bawaan browser menjadi dropdown jam (`00`-`23`) dan menit (`00`-`59`) kustom yang dibatasi tinggi tampilannya (maksimal 5 item yang terlihat, scrollable).
        *   Menyediakan visualisasi yang rapi, premium, serta menjamin keakuratan format 24 jam di semua jenis browser/locale.
    *   **Sinkronisasi Zona Waktu (Timezone Bug Fix)**:
        *   Mengubah `APP_TIMEZONE` di berkas [.env](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/.env) dari `Asia/Makassar` (WITA) menjadi `Asia/Jakarta` (WIB) agar sesuai dengan waktu lokal pengguna, memperbaiki bug di mana booking baru disetujui langsung terhapus otomatis karena selisih jam.

---

## Progress Lanjutan Fase 4: Inspeksi Pengembalian, Pengaturan Dinamis, dan Penyempurnaan UI

**Hari/Tanggal:** Senin, 8 Juni 2026  
**Fokus:** Penyempurnaan alur pengembalian buku berbasis inspeksi fisik, pengaturan dinamis checklist dan denda, pembatalan booking oleh anggota, perapian struktur navigasi petugas, serta optimasi tampilan halaman denda.

### Fitur & Perbaikan yang Diselesaikan Hari Ini

*   **Pembaruan Plan Implementasi Pengembalian**:
    *   Dokumen rencana implementasi diperjelas agar modul pengembalian tidak hanya mencakup denda keterlambatan, tetapi juga inspeksi fisik buku saat return.
    *   Alur baru menegaskan bahwa petugas melakukan checklist kondisi fisik, mencatat temuan, lalu menentukan sanksi berupa uang tunai, ganti buku, atau kombinasi.

*   **Inspeksi Fisik Saat Pengembalian Buku**:
    *   Menambahkan checklist inspeksi fisik pada proses pengembalian untuk memvalidasi kondisi buku sebelum transaksi dinyatakan selesai.
    *   Jika ada poin inspeksi yang gagal, sistem mewajibkan catatan inspeksi dan sanksi tambahan dari petugas.
    *   Menyimpan hasil inspeksi ke data peminjaman agar riwayat pengembalian dapat diaudit kembali.
    *   Untuk kasus kehilangan, stok tidak langsung dikembalikan ke inventaris sampai penyelesaian kasus dilakukan.

*   **Pengaturan Dinamis Checklist & Aturan Denda**:
    *   Menambahkan master data baru untuk `return_checklists` dan `penalty_rules` agar checklist inspeksi dan aturan denda tidak lagi hardcoded di view/controller.
    *   Petugas sekarang dapat mengelola item checklist aktif/nonaktif, urutan, dan aturan denda default dari menu pengaturan khusus.
    *   Alur pengembalian dan form denda manual membaca data aktif secara dinamis dari database.

*   **Perapian Sidebar Petugas**:
    *   Sidebar petugas direstrukturisasi agar menu tidak terlalu menumpuk.
    *   Membuat grup menu **Manajemen Peminjaman Buku** yang memuat `Peminjaman`, `Pengembalian`, `Booking`, `Antrian`, dan `Denda & Sanksi`.
    *   Membuat grup menu **Pengaturan** yang memuat `Rules Pengembalian` dan `Profil`.

*   **Pembatalan Booking oleh Anggota**:
    *   Menambahkan kemampuan bagi mahasiswa dan dosen untuk membatalkan booking sendiri dari halaman riwayat booking.
    *   Pembatalan hanya diperbolehkan pada status `pending` dan `disetujui`.
    *   Alasan pembatalan dibuat wajib diisi.
    *   Jika booking yang dibatalkan sebelumnya sudah disetujui, stok buku yang sempat direservasi dikembalikan otomatis.

*   **Perbaikan Bug Routing & View**:
    *   Memperbaiki bug parameter route pada halaman antrean petugas (`antrian_id` vs `id`) yang menyebabkan halaman gagal dibuka.
    *   Memperbaiki pemanggilan route aksi pelunasan denda agar sesuai dengan nama route yang terdaftar.
    *   Memperbaiki error parsing Blade pada halaman pengembalian yang dipicu struktur `@json(...)` kompleks di dalam view.

*   **Perbaikan Layout Halaman Petugas**:
    *   Menemukan penyebab konten tampak terpotong pada halaman denda: kombinasi `body.flex` + `main.flex-1` berbenturan dengan sidebar `fixed`.
    *   Pola layout halaman petugas dirapikan dengan menghapus `flex` pada `body` dan `flex-1` pada `main`, lalu cukup mengandalkan `ml-64` untuk offset sidebar.
    *   Perbaikan ini diterapkan secara konsisten ke banyak halaman petugas agar bug overflow horizontal tidak muncul lagi di modul lain.

*   **Optimasi Tabel dan Modal Denda**:
    *   Menghapus kolom `Keterangan` dari tabel denda agar tabel lebih ringkas.
    *   Menambahkan tombol aksi icon `info` untuk membuka detail denda dan mengubah tombol `Tandai Lunas` menjadi icon-only.
    *   Modal informasi denda diubah dari paragraf panjang menjadi tampilan terstruktur: `Aturan`, `Checklist Bermasalah`, `Catatan Aturan`, `Catatan Inspeksi`, dan fallback `Keterangan Umum`.
    *   Bagian `Tindak Lanjut` dihilangkan dari modal sesuai kebutuhan tampilan akhir.

*   **Validasi & Kompilasi Ulang View**:
    *   Seluruh penyesuaian view utama diverifikasi ulang menggunakan `php artisan view:cache`.
    *   Langkah ini memastikan perubahan Blade pada modul return, denda, booking, antrean, dan sidebar dapat dikompilasi tanpa error.

---

## Progress Lanjutan Fase 6: Sistem Notifikasi WhatsApp (Fonnte Gateway)

**Hari/Tanggal:** Jumat, 12 Juni 2026  
**Fokus:** Implementasi sistem notifikasi WhatsApp otomatis terintegrasi menggunakan Fonnte API dengan pengaturan dinamis oleh Admin melalui basis data.

### Fitur & Perbaikan yang Diselesaikan Hari Ini ✅

*   **Database & Model Pengaturan (`app_settings`)**:
    *   Membuat migrasi dan tabel `app_settings` untuk menyimpan konfigurasi secara fleksibel (key-value).
    *   Menyediakan `AppSettingSeeder` dengan default nilai: `fonnte_token` (API token Fonnte), `wa_notification_enabled` (aktif/nonaktif sistem), dan `wa_sender_name` (nama institusi untuk footer pesan).
    *   Membuat Model `AppSetting` lengkap dengan static helper `AppSetting::get($key)` dan `AppSetting::set($key, $value)` untuk mempermudah akses.

*   **Halaman Pengaturan WhatsApp Admin**:
    *   Menambahkan `SettingController` untuk memuat form pengaturan, menyimpan perubahan token ke database, dan melakukan uji coba pengiriman pesan via AJAX.
    *   Membuat view `admin.settings.index` dengan desain modern dan premium (warna primary turquoise `#00a5c0`, kartu sudut membulat, toggle status, masked input token dengan opsi show/hide).
    *   Mengintegrasikan fitur **"Uji Koneksi WA"** menggunakan Fetch API (AJAX) sehingga admin dapat langsung mencoba mengirim pesan test ke nomor HP tertentu tanpa reload halaman.
    *   Menambahkan menu navigasi "Pengaturan WA" pada sidebar Admin di `admin.dashboard`.

*   **Notifikasi WhatsApp Sinkron (Real-time)**:
    *   **Peminjaman Baru (`LoanController@store`)**: Otomatis mengirimkan pesan konfirmasi detail peminjaman dan tanggal batas pengembalian begitu transaksi berhasil disimpan oleh petugas.
    *   **Antrian Tersedia (`ReturnController@process`)**: Mengidentifikasi jika ada antrean peminjaman berikutnya yang menunggu ketika buku dikembalikan, memperbarui statusnya menjadi "tersedia", dan mengirim pesan WA pemberitahuan secara instan ke anggota yang antre.
    *   Semua pemanggilan dibungkus dengan blok `try-catch` dan normalisasi format nomor HP (mengubah awalan `08`/`8` menjadi `628`) demi memastikan tidak ada error yang memutus alur bisnis utama apabila API Gateway sedang bermasalah.

*   **Notifikasi WhatsApp Terjadwal (Laravel Scheduler)**:
    *   Membuat Artisan command `php artisan loans:send-reminders` untuk memproses notifikasi terjadwal.
    *   **Pengingat H-1 Jatuh Tempo**: Mengirim pengingat ramah ke anggota yang memiliki pinjaman aktif dengan batas waktu besok hari.
    *   **Status Terlambat**: Mengirim peringatan keterlambatan harian disertai perhitungan jumlah hari keterlambatan kepada anggota yang belum mengembalikan buku.
    *   Mendaftarkan penjadwalan tersebut di `routes/console.php` agar berjalan otomatis setiap hari pada pukul 08:00 WIB.

*   **Perbaikan Halaman Profil Dinamis**:
    *   Mengubah halaman profil `/profile` agar secara dinamis menyesuaikan layout dan sidebar navigasi berdasarkan role pengguna (Admin, Petugas, Dosen, Mahasiswa).
    *   Menambahkan input **Nomor HP / WhatsApp** pada form edit profil agar semua jenis user dapat langsung memperbarui nomor telepon mereka demi kebutuhan integrasi notifikasi WhatsApp.
    *   Menampilkan data detail personal read-only seperti NIM (Mahasiswa), NIP (Dosen/Petugas), Program Studi (Mahasiswa/Dosen), Jabatan (Petugas), dan Semester (Mahasiswa) di form profil.
    *   Menyesuaikan aturan validasi di `ProfileUpdateRequest` dan penanganan penyimpanan data di `ProfileController@update`.

*   **Perombakan Halaman Kelola User Admin**:
    *   Mengganti nama menu "Kelola Anggota" menjadi "Kelola User" pada sidebar Admin secara global (di dashboard, settings, profile, dan halaman user).
    *   Merombak berkas view index, create, dan edit di area manajemen user admin agar tidak lagi memakai layout Breeze default, melainkan memakai layout sidebar admin kustom premium dengan nuansa warna primary turquoise `#00a5c0` dan card rounded-3xl.

*   **Refactoring Komponen Sidebar per Role User**:
    *   Mengekstraksi kode sidebar navigasi untuk role **Admin**, **Dosen**, dan **Mahasiswa** ke berkas layout partials terpisah (`admin/layouts/sidebar.blade.php`, `dosen/layouts/sidebar.blade.php`, `mahasiswa/layouts/sidebar.blade.php`) untuk menghilangkan duplikasi kode HTML di 16 berkas view.
    *   Memperbarui halaman profil bersama (`profile/edit.blade.php`) agar memanggil file sidebar partial tersebut secara dinamis menggunakan `@include()` terstruktur.

*   **Verifikasi Awal**:
    *   Menjalankan pengujian sintaks PHP (`php -l`) di semua berkas baru/modifikasi dan seluruhnya terbukti bebas error.
    *   Melakukan uji coba pemanggilan command `php artisan loans:send-reminders` secara manual dan berhasil diproses dengan status sukses.
    *   Mengompilasi seluruh file Blade menggunakan `php artisan view:cache` dan terbukti sukses 100% bebas error parsing Blade.

---

## Progress Lanjutan Fase 5: Arsip Digital

**Hari/Tanggal:** Selasa, 30 Juni 2026  
**Fokus:** Implementasi inti modul repositori karya tulis mahasiswa mencakup upload arsip, katalog arsip, verifikasi petugas, preview PDF, surat tanda terima, dan integrasi ke sirkulasi fisik.

### Fitur & Perubahan yang Diselesaikan

*   **Fondasi Data Arsip Digital**:
    *   Menambahkan migration baru untuk melengkapi 3 tabel arsip (`laporan_pkl`, `proposal_ta`, `laporan_tugas_akhir`) dengan field status proses, catatan petugas, path preview PDF, path surat tanda terima, nomor surat, timestamp verifikasi, dan timestamp penerimaan fisik.
    *   Menambahkan helper `ArsipDigital` untuk menyatukan mapping tipe arsip, label tampilan, field judul, status katalog, serta pencarian lintas model.

*   **Service PDF & Surat Tanda Terima**:
    *   Menginstall dependency `setasign/fpdi` dan `setasign/fpdf`.
    *   Membuat `PdfPreviewService` untuk memotong PDF asli menjadi preview maksimal 10 halaman pertama.
    *   Membuat `SuratTandaTerimaService` untuk membangun surat tanda terima otomatis dengan 2 mode: memakai template PDF jika tersedia, atau fallback generator PDF jika template final belum disiapkan.
    *   Membuat `SuratTandaTerimaMail` beserta template email HTML untuk pengiriman surat ke mahasiswa setelah proses verifikasi.

*   **Modul Mahasiswa: Upload Repository**:
    *   Membuat `Mahasiswa\ArsipController` dengan fitur upload arsip, edit arsip, update arsip, hapus arsip, dan riwayat arsip milik mahasiswa.
    *   Menambahkan validasi hak akses agar mahasiswa hanya bisa mengubah arsip miliknya sendiri dengan status `pending` atau `ditolak`.
    *   Menambahkan halaman `Upload Repository` dan `Edit Arsip`.

*   **Modul Petugas: Kelola Arsip Digital**:
    *   Membuat `Petugas\ArsipController` untuk daftar arsip, detail arsip, verifikasi, penolakan, konfirmasi penerimaan fisik, koreksi data bibliografi, penghapusan arsip, unduh full PDF/Word, dan unduh ulang surat.
    *   Menambahkan pengiriman email surat tanda terima saat verifikasi dengan guard error jika email mahasiswa tidak tersedia atau pengiriman gagal.
    *   Menambahkan proteksi agar arsip tidak bisa dihapus jika masih memiliki peminjaman, booking, atau antrian aktif.

*   **Katalog Arsip Mahasiswa & Dosen**:
    *   Membuat `ArsipKatalogController` untuk daftar katalog, detail arsip, dan streaming preview PDF.
    *   Menambahkan view katalog arsip untuk mahasiswa dan dosen dengan filter judul, jenis arsip, program studi, dan tahun.
    *   Menambahkan integrasi tombol booking/antrian fisik jika arsip sudah berstatus `aktif`.

*   **Integrasi ke Sirkulasi Perpustakaan**:
    *   Memperbarui `Collection`, `Booking`, `LoanController`, `BookingController`, `ReturnController`, dan `AntrianController` agar koleksi arsip aktif dapat diproses seperti koleksi fisik lain tanpa mengasumsikan semua item adalah buku.
    *   Menambahkan helper sinkronisasi stok generik di model `Collection` agar perubahan stok buku dan arsip aktif konsisten saat booking, pinjam, batal, atau dikembalikan.

*   **Navigasi & UI**:
    *   Menambahkan grup baru `Koleksi Perpustakaan` pada sidebar petugas yang berisi `Kelola Buku` dan `Kelola Arsip Digital`.
    *   Mengaktifkan menu `Upload Repository` pada sidebar mahasiswa dan menambahkan menu `Katalog Arsip` untuk mahasiswa dan dosen.
    *   Menambahkan seluruh view baru fase 5 untuk mahasiswa, dosen, petugas, dan email.

### Verifikasi yang Sudah Dilakukan

*   `php -l` pada file backend inti fase 5: **sukses**
*   `php artisan view:cache`: **sukses**
*   `php artisan route:list` untuk route arsip/katalog arsip: **sukses**

### Catatan Tindak Lanjut

*   Migration fase 5 belum dijalankan ke database aktif.
*   Template final `storage/app/templates/surat_tanda_terima.pdf` masih perlu disediakan untuk hasil surat yang sesuai desain akhir.
*   SMTP nyata di `.env` masih perlu dikonfigurasi agar email verifikasi benar-benar terkirim ke alamat mahasiswa.
*   `php artisan test` masih gagal pada test auth bawaan karena konfigurasi lama project yang mensyaratkan `users.role_id`, sehingga belum dapat dipakai sebagai indikator khusus untuk modul fase 5.

---

## Progress Lanjutan Fase 6 & Fitur Kelola Sesi Voting Buku (Petugas View)

**Hari/Tanggal:** Selasa, 30 Juni 2026 (Sore)  
**Fokus:** Penyelesaian modul tambahan Fase 6 (Usulan Buku, Laporan Excel/Print, Log Aktivitas, Grafik Dashboard) dan pembangunan modul Kelola Sesi Voting Buku bagi Petugas.

### Fitur & Perbaikan yang Diselesaikan Hari Ini ✅

*   **Sistem Usulan Buku Baru (Mahasiswa, Dosen, Petugas)**:
    *   **Anggota (Mahasiswa/Dosen)**: Formulir pengajuan usulan buku baru serta halaman riwayat usulan ber-badge status warna. Teks alasan usulan ditampilkan penuh (*word wrap*) tanpa terpotong untuk mempermudah penilaian.
    *   **Petugas**: Panel verifikasi usulan masuk (Setuju langsung / Setuju & Masukkan ke Sesi Voting Aktif / Tolak).
*   **Modul Laporan & Ekspor Data (Excel & Print Layout)**:
    *   Petugas dapat memfilter laporan sirkulasi periodik.
    *   Menyediakan tombol cetak HTML ber-kop surat resmi PSDKU POLNEP Sukamara yang memicu print browser secara otomatis (`window.print()`).
    *   Menyediakan ekspor file spreadsheet `.xlsx` Excel yang didukung oleh library `phpoffice/phpspreadsheet` untuk rekapitulasi data sirkulasi dan data koleksi pustaka lengkap (Buku + Arsip Digital PKL/TA).
*   **Pemantauan Log Aktivitas Sistem (Admin)**:
    *   Admin dapat memantau log aktivitas sistem terstruktur (Login/Logout, Sirkulasi, dan aktivitas unggah/verifikasi arsip digital).
*   **Grafik Statistik Visual (Chart.js)**:
    *   Dashboard Admin dan Petugas sekarang memuat visualisasi real-time grafik garis (tren peminjaman bulanan) dan pie/doughnut chart (distribusi kategori buku terpopuler) berbasis data SQL dinamis.
*   **Modul Kelola Sesi Voting Buku (Petugas View)**:
    *   **CRUD Sesi Voting**: Petugas dapat membuat sesi voting baru dengan judul, deskripsi, tanggal mulai, dan tanggal selesai.
    *   **Detail Rekapitulasi Suara**: Menampilkan statistik hasil suara kandidat usulan buku dengan bar persentase horizontal yang responsif serta log nama pemilih.
    *   **Sidebar & Rute**: Penambahan menu "Kelola Voting Buku" di sidebar petugas dan pendaftaran route resource `voting` baru.
*   **Pembersihan & Perbaikan Bug Database**:
    *   **Perbaikan Field `prodi_name`**: Mengubah referensi query/view dari `prodi_name` ke `nama_prodi` pada katalog arsip mahasiswa.
    *   **Perbaikan Field `category_name`**: Menyelaraskan relasi kategori pustaka menjadi `kategori_name` pada cetak laporan dan queries dashboard.
    *   **Perbaikan Join `category_id`**: Mengubah kunci join categories dari `category_id` menjadi `kategori_id` di database.
    *   **Penyederhanaan Dashboard**: Menghapus widget "Reading Progress" dari dashboard Mahasiswa/Dosen dan menyederhanakan panel widget "Pintasan Cepat" & "Pengumuman Internal" di dashboard Petugas atas permintaan pengguna.

### Verifikasi yang Sudah Dilakukan
*   Seluruh rute baru dan controller voting petugas telah terdaftar dengan benar (`php artisan route:list` sukses).
*   Kompilasi template Blade berhasil tanpa ada error parsing.

---

## Progress Lanjutan Fase 5: Pelacakan Waktu Tutup Tab PDF (HTML Wrapper Viewer) & Tanggal Kembali Riwayat Digital

**Hari/Tanggal:** Selasa, 7 Juli 2026  
**Fokus:** Implementasi pelacakan waktu tutup tab PDF menggunakan penampil HTML kustom (HTML Wrapper Viewer) untuk mengisi tanggal kembali pada riwayat baca online secara otomatis serta integrasi sirkulasi digital terpadu secara visual.

### Fitur & Perbaikan yang Diselesaikan Hari Ini ✅

*   **HTML Wrapper Viewer Full-Screen tanpa Header**:
    *   Membuat berkas view kustom [arsip-pdf-viewer.blade.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/shared/arsip-pdf-viewer.blade.php) yang memuat dokumen PDF di dalam tag `iframe` dengan tampilan 100% penuh layar (*full screen*).
    *   Menghilangkan header atas untuk menyajikan pengalaman membaca native yang bersih dan memprioritaskan kenyamanan visual pengguna.

*   **Pencatatan Log Waktu Buka & Selesai Baca (Tanggal Kembali)**:
    *   **Tanggal Pinjam / Mulai**: Tercatat secara otomatis ketika rute katalog arsip dibuka oleh pengguna.
    *   **Tanggal Kembali / Selesai (Tutup Tab)**: Menggunakan API browser `navigator.sendBeacon` pada event window `unload` dan `beforeunload` untuk mengirimkan sinyal penutupan secara andal ke backend server Laravel guna mengisi kolom `finished_at` pada tabel database `archive_read_logs`.
    *   **Pencegahan Salah Deteksi Beralih Tab**: Menghapus event listener `visibilitychange` dan `pagehide` agar beralih tab, meminimalkan browser, atau mengunci layar perangkat **TIDAK** memicu pengisian tanggal kembali (status pembacaan tetap aktif).

*   **Skema Database & Model Baru**:
    *   Membuat migrasi untuk menambahkan kolom `finished_at` (timestamp, nullable) pada tabel `archive_read_logs` dan menjalankannya dengan sukses.
    *   Memperbarui properti `$fillable` dan `$casts` pada model [ArchiveReadLog.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/app/Models/ArchiveReadLog.php) agar kolom `finished_at` dikenali sebagai objek `datetime` (Carbon).

*   **Pengecualian Proteksi CSRF**:
    *   Mengecualikan rute POST penutupan log `katalog-arsip/read-log/*/close` dari verifikasi token CSRF di [bootstrap/app.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/bootstrap/app.php) guna menjamin browser dapat mengirimkan request latar belakang (*beacon request*) secara langsung tanpa hambatan token kedaluwarsa. Keamanan tetap terjamin melalui validasi ID pengguna (`auth()->id()`) di controller.

*   **Pencegahan Cache Agresif Browser (Bug Suffix .pdf)**:
    *   Mengubah rute katalog arsip utama `katalog-arsip.full` di [routes/web.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/routes/web.php) agar tidak menggunakan ekstensi `.pdf` di belakang URL. Hal ini mencegah browser seperti Google Chrome dan Microsoft Edge dari melakukan caching statis secara sepihak dan memotong pemanggilan HTML wrapper.

*   **Visualisasi Riwayat Terpadu dengan Badge Animasi**:
    *   Memperbarui [MemberLoanController.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/app/Http/Controllers/MemberLoanController.php) untuk memetakan `tgl_pinjam` ke `created_at` dan `tgl_kembali` ke `finished_at`.
    *   Memperbarui halaman Riwayat [Mahasiswa](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/mahasiswa/loans/history.blade.php) dan [Dosen](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/dosen/loans/history.blade.php) untuk memformat tanggal dan jam pembacaan digital lengkap dengan penanda "WIB".
    *   Jika dokumen sedang aktif dibaca (belum ditutup), kolom Tanggal Kembali menampilkan **Badge Animasi Hijau Kedip "Membaca"** secara dinamis.

### Verifikasi yang Sudah Dilakukan
*   Menjalankan migrasi database kolom `finished_at`: **sukses**
*   Uji coba penutupan tab secara fisik: **sukses** (kolom Tanggal Kembali langsung terisi real-time)
*   Uji coba beralih tab browser: **sukses** (tidak memicu penutupan sesi baca)
*   Pembersihan cache rute, view, config, dan cache aplikasi: **sukses**

