# Rencana Implementasi: Fitur Backup & Restore Database (Admin)

Fitur ini memungkinkan Administrator untuk mencadangkan (backup) seluruh data basis data MySQL ke berkas `.sql` dan memulihkan (*restore*) database dari berkas cadangan yang diunggah. Hal ini bertujuan untuk mencegah kehilangan data akibat kegagalan sistem atau kesalahan operasional.

## Rasional Pembagian Peran (Separation of Concerns)

> [!NOTE]
> **Pemisahan Hak Akses Admin vs Petugas:**
> *   **Admin (Fokus Sistem & Pemeliharaan):** Hanya memiliki hak untuk melakukan **Backup & Restore (Import/Ekspor Database `.sql` secara menyeluruh)**. Admin tidak memiliki halaman untuk meng-import buku atau arsip secara individual demi menjaga prinsip *Separation of Concerns* (pemisahan wewenang).
> *   **Petugas (Fokus Operasional Harian):** Memiliki hak untuk melakukan **Import Buku & Import Arsip Digital secara individual** menggunakan Excel untuk mempermudah pekerjaan operasional mereka sehari-hari.
> *   Jika Admin perlu meng-import data buku/arsip secara langsung, Admin disarankan menggunakan akun Petugas. Hal ini menghindari duplikasi kode dan menjaga arsitektur *Role-Based Access Control* (RBAC) tetap bersih dan profesional.

## User Review Required

> [!WARNING]
> **Risiko Proses Restore (Pemulihan Data):**
> Proses *restore* database bersifat merusak (*destructive*). Saat berkas cadangan SQL dijalankan, seluruh data di database saat ini akan dihapus (drop tables) dan digantikan secara penuh oleh data dari berkas cadangan tersebut. Sistem akan mematikan sementara pengecekan kunci asing (`SET FOREIGN_KEY_CHECKS=0`) agar relasi tidak memblokir import, lalu menyalakannya kembali setelah selesai.

> [!NOTE]
> **Metode Backup Berbasis PHP Murni:**
> Untuk memastikan kompatibilitas penuh saat dijalankan di server lokal (seperti Laragon di Windows) maupun web hosting tanpa tergantung pada perintah command line `mysqldump` (yang sering diblokir atau tidak terdaftar di sistem PATH), proses ekspor database dirancang menggunakan **Script Generator SQL berbasis PHP**. Script ini membaca struktur tabel (`SHOW CREATE TABLE`) dan data baris untuk disusun menjadi file SQL terformat.

---

## Proposed Changes

### Backend Route & Controller

#### [MODIFY] [web.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/routes/web.php)
Menambahkan rute-rute baru di grup middleware admin (`role:admin`) di bawah grup `settings`:
*   `GET /admin/settings/backup` -> `SettingController@backupIndex` (`admin.settings.backup`)
*   `POST /admin/settings/backup/run` -> `SettingController@backupRun` (`admin.settings.backup.run`)
*   `POST /admin/settings/backup/restore` -> `SettingController@backupRestore` (`admin.settings.backup.restore`)
*   `GET /admin/settings/backup/download/{filename}` -> `SettingController@backupDownload` (`admin.settings.backup.download`)
*   `DELETE /admin/settings/backup/delete/{filename}` -> `SettingController@backupDelete` (`admin.settings.backup.delete`)

#### [MODIFY] [SettingController.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/app/Http/Controllers/Admin/SettingController.php)
Menambahkan metode:
1.  `backupIndex()`:
    *   Membaca direktori `storage/app/backups/`.
    *   Mengambil daftar file `.sql` beserta ukuran berkas dan waktu pembuatan.
    *   Mengurutkan berkas cadangan dari yang terbaru ke terlama.
    *   Mengembalikan view `admin.settings.backup`.
2.  `backupRun()`:
    *   Membuat folder `backups` jika belum ada.
    *   Menghasilkan string SQL dump (struktur & data semua tabel perpustakaan) secara dinamis menggunakan database queries.
    *   Menyimpan file cadangan dengan penamaan: `backup_[database_name]_[date_timestamp].sql`.
    *   Mencatat aktivitas ke `ActivityLog`.
    *   Mengalihkan kembali dengan pesan sukses.
3.  `backupDownload($filename)`:
    *   Mengunduh file `.sql` tertentu dari folder `storage/app/backups/`.
4.  `backupDelete($filename)`:
    *   Menghapus file `.sql` terpilih dari folder backups.
5.  `backupRestore(Request $request)`:
    *   Validasi berkas yang diunggah harus memiliki ekstensi `.sql`.
    *   Melakukan eksekusi raw SQL dengan `DB::unprepared($sql)` setelah menonaktifkan pengecekan foreign key.
    *   Mencatat aktivitas pemulihan ke `ActivityLog`.
    *   Mengalihkan dengan membawa status sukses/gagal.

---

### Frontend Views & UI Design

#### [MODIFY] [sidebar.blade.php (Admin Layout)](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/admin/layouts/sidebar.blade.php)
*   Menambahkan submenu baru di dalam grup Pengaturan:
    ```html
    <a class="flex items-center gap-3 px-4 py-2.5 rounded-2xl {{ request()->routeIs('admin.settings.backup') ? 'bg-surface-container text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low' }} transition-all" href="{{ route('admin.settings.backup') }}">
        <span class="material-symbols-outlined text-[18px]">backup</span>
        <span class="text-sm">Backup & Restore</span>
    </a>
    ```

#### [NEW] [backup.blade.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/admin/settings/backup.blade.php)
Membuat halaman pengaturan baru dengan desain premium:
*   **Tombol "Buat Cadangan Baru"**: Tombol mencolok untuk memicu backup instan.
*   **Tabel Daftar Berkas Cadangan**: Menampilkan nama file, tanggal dibuat, ukuran berkas, dan aksi (Unduh, Pulihkan, Hapus).
*   **Aksi Pulihkan (Restore)**: Tombol pemulihan yang dilengkapi dengan dialog konfirmasi keamanan ganda agar admin tidak sengaja menimpa database aktif.
*   **Form Unggah File SQL**: Area khusus untuk mengunggah file `.sql` dari komputer lokal guna memulihkan database secara langsung.
*   **Kotak Peringatan**: Informasi penting terkait bahaya overwrite data saat restore.

---

## Verification Plan

### Automated Tests
*   `php -l app/Http/Controllers/Admin/SettingController.php`
*   `php artisan view:cache`

### Manual Verification
1.  Login sebagai **Admin**.
2.  Buka menu **Pengaturan -> Backup & Restore** di sidebar. Pastikan halamannya tampil secara premium.
3.  Klik **Buat Cadangan Baru**. Pastikan file SQL berhasil dibuat di folder `storage/app/backups/` dan masuk ke daftar tabel.
4.  Coba **Unduh** file SQL tersebut dan buka dengan text editor untuk memastikan skema tabel dan data ter-export lengkap.
5.  Uji **Unggah & Restore** menggunakan file SQL yang tidak valid atau rusak untuk memastikan error tertangkap dan database aman.
6.  Coba tambahkan satu data buku baru, lalu jalankan **Restore** menggunakan file SQL yang dicadangkan sebelumnya. Pastikan database kembali ke keadaan semula (data buku baru hilang, diganti database cadangan).
7.  Uji **Hapus** berkas cadangan dari daftar untuk memastikan file terhapus secara fisik dari server.
