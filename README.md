# SIPUS PSDKU POLNEP

SIPUS PSDKU POLNEP adalah sistem informasi perpustakaan berbasis Laravel untuk mengelola koleksi buku, arsip digital mahasiswa, anggota, peminjaman, pengembalian, booking, antrean, usulan buku, voting, denda dan sanksi, laporan, serta notifikasi.

## Persyaratan

- PHP 8.2 atau lebih baru
- Composer
- Node.js dan npm
- SQLite (konfigurasi bawaan) atau MySQL
- Ekstensi PHP yang dibutuhkan Laravel dan PhpSpreadsheet

## Instalasi singkat

1. Clone atau salin repository, lalu masuk ke direktori proyek.

   ```bash
   git clone <URL_REPOSITORY>
   cd perpustakaan
   ```

2. Instal dependency PHP dan JavaScript.

   ```bash
   composer install
   npm install
   ```

3. Buat file konfigurasi lingkungan.

   Linux/macOS:

   ```bash
   cp .env.example .env
   ```

   Windows PowerShell:

   ```powershell
   Copy-Item .env.example .env
   ```

4. Buat application key.

   ```bash
   php artisan key:generate
   ```

5. Siapkan database. Konfigurasi bawaan menggunakan SQLite.

   Linux/macOS:

   ```bash
   touch database/database.sqlite
   ```

   Windows PowerShell:

   ```powershell
   if (-not (Test-Path database/database.sqlite)) { New-Item database/database.sqlite -ItemType File }
   ```

   Untuk MySQL, ubah bagian database pada `.env`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. Jalankan migration dan seeder.

   ```bash
   php artisan migrate --seed
   ```

7. Buat symbolic link untuk file yang dapat diakses publik dan build aset aplikasi.

   ```bash
   php artisan storage:link
   npm run build
   ```

8. Jalankan aplikasi.

   ```bash
   php artisan serve
   ```

   Aplikasi dapat dibuka melalui:

   ```text
   http://127.0.0.1:8000
   ```

Untuk pengembangan frontend, jalankan `npm run dev` pada terminal terpisah.

## URL penting

| Halaman | URL |
|---|---|
| Beranda | `http://127.0.0.1:8000/` |
| Login | `http://127.0.0.1:8000/login` |
| Registrasi anggota | `http://127.0.0.1:8000/register` |
| Lupa password | `http://127.0.0.1:8000/forgot-password` |
| Dashboard sesuai role | `http://127.0.0.1:8000/dashboard` |
| Dashboard Admin | `http://127.0.0.1:8000/admin/dashboard` |
| Dashboard Petugas | `http://127.0.0.1:8000/petugas/dashboard` |
| Dashboard Dosen | `http://127.0.0.1:8000/dosen/dashboard` |
| Dashboard Mahasiswa | `http://127.0.0.1:8000/mahasiswa/dashboard` |

Setelah login berhasil, sistem otomatis mengarahkan pengguna ke dashboard berdasarkan role.

## Akun uji bawaan

Akun berikut dibuat oleh `database/seeders/UserSeeder.php` setelah menjalankan `php artisan migrate --seed`.

| Role | Email | Password |
|---|---|---|
| Admin | `admin@perpustakaan.com` | `admin123` |
| Petugas | `petugas@perpustakaan.com` | `password` |
| Dosen | `dosen@perpustakaan.com` | `password` |
| Mahasiswa | `mahasiswa@perpustakaan.com` | `password` |

> Akun tersebut hanya untuk pengembangan dan pengujian. Ganti seluruh password sebelum aplikasi digunakan pada lingkungan produksi.

## Cara menggunakan aplikasi

1. Buka halaman `/login`.
2. Masukkan email dan password sesuai akun yang digunakan.
3. Sistem akan membuka dashboard berdasarkan role pengguna.
4. Gunakan menu pada sidebar sesuai kebutuhan:

   - **Admin:** mengelola pengguna, program studi, jurusan, pengaturan notifikasi, template surat, dan log aktivitas.
   - **Petugas:** mengelola buku dan arsip digital, memverifikasi anggota, memproses peminjaman/pengembalian, booking, antrean, denda dan sanksi, serta laporan.
   - **Mahasiswa:** mencari buku dan arsip, melakukan booking atau antrean, mengajukan usulan dan voting buku, melihat pinjaman, serta mengunggah arsip digital.
   - **Dosen:** mencari buku dan arsip, melakukan booking atau antrean, melihat pinjaman, serta menggunakan fitur usulan dan voting buku.

5. Gunakan menu profil untuk memperbarui data atau mengganti password.
6. Gunakan menu **Logout** setelah selesai menggunakan aplikasi.

## Registrasi anggota baru

1. Buka `/register`.
2. Isi data mahasiswa atau dosen, termasuk identitas dan foto yang diwajibkan.
3. Akun baru akan berstatus menunggu verifikasi.
4. Petugas memeriksa dan menyetujui akun melalui menu pengelolaan anggota.
5. Setelah disetujui, anggota dapat login melalui `/login`.

## Queue dan scheduler

Beberapa notifikasi menggunakan queue database. Jalankan worker pada terminal terpisah jika fitur tersebut digunakan:

```bash
php artisan queue:work
```

Untuk menjalankan pengingat peminjaman terjadwal pada lingkungan pengembangan:

```bash
php artisan schedule:work
```

Pada server produksi, konfigurasi cron Laravel Scheduler sesuai dokumentasi Laravel.

## Konfigurasi notifikasi

Konfigurasi awal email menggunakan `MAIL_MAILER=log`, sehingga email ditulis ke log aplikasi. SMTP, WhatsApp, dan Telegram dapat dikonfigurasi melalui menu pengaturan Admin atau variabel lingkungan yang sesuai.

Jangan menyimpan token API, password SMTP, `APP_KEY`, atau kredensial database produksi di README maupun repository publik.

## Perintah berguna

```bash
# Membersihkan cache konfigurasi dan view
php artisan optimize:clear

# Menjalankan pengujian
php artisan test

# Menampilkan seluruh route
php artisan route:list
```

Dokumentasi alur penggunaan yang lebih lengkap tersedia di direktori `dokumentasi/`.
