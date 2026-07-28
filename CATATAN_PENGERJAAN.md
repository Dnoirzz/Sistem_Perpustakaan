# Catatan Pengerjaan Sistem Perpustakaan Digital POLNEP
**Tanggal:** 28 - 29 Juli 2026  
**Repository:** Perpustakaan PSDKU POLNEP  

---

## 📋 Ringkasan Pengerjaan & Pembaharuan Fitur

### 1. Logika Antrian Buku (Auto-Reset & Posisi Antrian)
- **Auto-Reset Nomor Antrian:** Penomoran `no_antrian` buku kini dihitung hanya berdasarkan antrian yang sedang aktif (`menunggu`, `tersedia`). Jika antrian aktif habis (0), nomor antrian buku tersebut otomatis di-reset mulai dari **#1**.
- **Pelacakan Posisi Antrian:** Menambahkan kalkulasi dinamis `people_ahead` untuk member (Mahasiswa & Dosen) sehingga pengguna mengetahui berapa jumlah orang yang ada di depannya.

---

### 2. Fitur Pembatalan Mandiri Antrian oleh Pengguna (Mahasiswa & Dosen)
- **Skema Database:** Membuat migrasi baru (`2026_07_28_000001_add_dibatalkan_to_antrian_status_enum.php`) dan memperbarui migrasi transaksi untuk menambahkan nilai `'dibatalkan'` pada ENUM kolom `status` tabel `antrian`.
- **Backend Controller:** Menambahkan fungsi `cancel($antrian_id)` di `AntrianController.php`. Apabila antrian berstatus `'tersedia'` dibatalkan, giliran otomatis dipindah ke pengantri berikutnya via `Antrian::checkAndNotifyAvailableQueue()` serta mengirim notifikasi WhatsApp.
- **Tampilan UI:** Menambahkan tombol & modal aksi **"Batalkan"** pada tabel & kartu antrian tampilan Mahasiswa dan Dosen (Desktop & Mobile).

---

### 3. Perbaikan Overlay & Responsive Drawer Sidebar Mobile
- Memperbarui `z-index` overlay backdrop dari `z-45` menjadi `z-[45]` pada 4 file sidebar (`admin`, `petugas`, `dosen`, `mahasiswa`).
- Memastikan sidebar mobile dapat ditutup secara instan dan lancar saat pengguna mengetuk (*tap*) di mana saja di luar area drawer sidebar.

---

### 4. Penyempurnaan Halaman Beranda (Welcome Page)
- **Layout 2 Kolom Modern:** Menampilkan *Hero Section* 2 kolom yang memadukan headline utama dengan grafik ilustrasi vektor perpustakaan digital (`public/img/digital_library_hero.png`).
- **Data Real-Time Database:** Menghubungkan statistik `Total Buku`, `Anggota Aktif`, dan `Arsip Digital` serta daftar `Buku Unggulan` langsung dari database.
- **Warna & Style Konsisten:** Mempertahankan warna tombol & latar belakang tema asli (`bg-primary`, `bg-secondary-container`, `bg-surface`).
- **Footer Biru POLNEP:** Footer bergaya modern dengan latar biru khas POLNEP (`#2d80c5`), dilengkapi Alamat Resmi Kampus (`Jl. Tjilik Riwut, Natai Sedawak, Sukamara`), Telepon (`0561 736180`), dan Email (`kampus@polnep.ac.id`).
- **Badge Informatif:** Menambahkan badge Jam Operasional Perpustakaan (`Senin – Jumat (08:00 – 14:00 WIB)`) serta 3 kartu fitur ringkas (*Fitur Reservasi Buku*, *Notifikasi WhatsApp*, *Karya Ilmiah*).

---

## 🛠️ Daftar File Yang Diubah / Dibuat:
- `database/migrations/2026_07_28_000001_add_dibatalkan_to_antrian_status_enum.php` (Baru)
- `public/img/digital_library_hero.png` (Baru)
- `app/Http/Controllers/AntrianController.php`
- `app/Http/Controllers/Petugas/AntrianController.php`
- `app/Http/Controllers/Petugas/LoanController.php`
- `app/Http/Controllers/Petugas/ReturnController.php`
- `app/Models/Antrian.php`
- `app/Models/Book.php`
- `routes/web.php`
- `resources/views/welcome.blade.php`
- `resources/views/mahasiswa/antrian/index.blade.php`
- `resources/views/dosen/antrian/index.blade.php`
- `resources/views/petugas/antrian/index.blade.php`
- `resources/views/petugas/bookings/index.blade.php`
- `resources/views/admin/layouts/sidebar.blade.php`
- `resources/views/petugas/layouts/sidebar.blade.php`
- `resources/views/dosen/layouts/sidebar.blade.php`
- `resources/views/mahasiswa/layouts/sidebar.blade.php`
- `resources/views/shared/arsip-katalog-index.blade.php`
- `resources/views/shared/arsip-katalog-show.blade.php`
