# Implementation Plan - Universal Header Bell Notification System (Sistem Lonceng Notifikasi Header Menyeluruh)

**Tanggal**: 31 Juli 2026  
**Project**: SIPUS PSDKU POLNEP di Kabupaten Sukamara  
**Dokumen**: Perencanaan Teknis Sistem Notifikasi Header Web (Lonceng Notifikasi `🔔`)

---

## 1. Ringkasan Fitur

Mengimplementasikan **Sistem Lonceng Notifikasi Header (`🔔`) Universal** di seluruh peran pengguna (**Mahasiswa, Dosen, Petugas, Admin**). Sistem notifikasi ini menyimpan riwayat pesan penting di database secara permanen, menampilkan jumlah notifikasi belum dibaca melalui badge merah (`🔴`), dan memungkinkan pengguna untuk mengklik notifikasi untuk langsung diarahkan ke halaman detail transaksi terkait.

---

## 2. Cakupan Pemicu Notifikasi (Notification Triggers)

### A. 📁 Arsip Digital (Laporan PKL, Proposal TA, Laporan TA)
- **Upload Arsip Baru**: Mahasiswa/Dosen mengunggah karya ilmiah ➔ Notifikasi dikirim ke **Petugas & Admin** (*"Unggahan arsip digital baru dari [Nama Mahasiswa]"*).
- **Verifikasi / Disetujui**: Petugas menyetujui arsip ➔ Notifikasi dikirim ke **Mahasiswa/Dosen** (*"Arsip digital [Judul] telah diverifikasi dan dipublikasikan"*).
- **Penolakan / Perbaikan**: Petugas menolak / meminta revisi arsip ➔ Notifikasi dikirim ke **Mahasiswa/Dosen** (*"Arsip digital [Judul] memerlukan perbaikan"*).

### B. 🔖 Booking & Antrian Ketersediaan Buku
- **Pengajuan Booking**: Anggota mengajukan booking buku ➔ Notifikasi ke **Anggota** (*"Pengajuan booking [Judul] berhasil"*) & **Petugas** (*"Antrian booking baru untuk [Judul]"*).
- **Buku Siap Diambil**: Petugas menyetujui booking / stok buku tersedia ➔ Notifikasi ke **Anggota** (*"Buku [Judul] siap diambil di perpustakaan sebelum [Batas Waktu Ambil]"*).
- **Pembatalan / Expired**: Booking dibatalkan atau kadaluwarsa ➔ Notifikasi ke **Anggota** (*"Booking buku [Judul] telah dibatalkan/kadaluwarsa"*).

### C. 🔄 Sirkulasi Peminjaman & Pengembalian Buku
- **Peminjaman Baru**: Petugas memproses transaksi peminjaman ➔ Notifikasi ke **Anggota** (*"Buku [Judul] berhasil dipinjam. Batas pengembalian: [Tanggal]"*).
- **Pengembalian Berhasil**: Petugas memproses pengembalian ➔ Notifikasi ke **Anggota** (*"Buku [Judul] telah berhasil dikembalikan. Terima kasih!"*).
- **Peringatan Jatuh Tempo (Overdue Alert)**: Peminjaman mendekati / melewati tanggal pengembalian ➔ Notifikasi ke **Anggota** (*"Peringatan: Peminjaman buku [Judul] mendekati/melewati batas pengembalian"*).

### D. 💸 Sanksi & Denda
- **Pencatatan Denda Baru**: Terjadi denda (terlambat/rusak/hilang) ➔ Notifikasi ke **Anggota** (*"Sanksi denda sebesar Rp [Nominal] telah tercatat"*).
- **Pelunasan Denda**: Denda dilunasi ➔ Notifikasi ke **Anggota** (*"Pembayaran denda sebesar Rp [Nominal] telah dikonfirmasi LUNAS"*).

---

## 3. Desain Database & Struktur Kode

### A. Tabel Database (`app_notifications`)
```sql
Schema::create('app_notifications', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
    $table->string('title');
    $table->text('message');
    $table->string('url')->nullable(); // Link redirect saat notifikasi diklik
    $table->string('type')->default('info'); // 'arsip', 'booking', 'sirkulasi', 'denda', 'info'
    $table->boolean('is_read')->default(false);
    $table->timestamps();
});
```

### B. Helper Notifikasi di Model (`AppNotification.php`)
```php
// Kirim notifikasi ke 1 pengguna spesifik
AppNotification::send($userId, $title, $message, $url, $type);

// Kirim notifikasi ke seluruh pengguna dengan role tertentu (misal: 'petugas', 'admin')
AppNotification::sendToRoles(['petugas', 'admin'], $title, $message, $url, $type);
```

---

## 4. Rencana Komponen Antarmuka Pengguna (UI)

- **Komponen Blade `<x-notification-bell />`**:
  - Diletakkan pada topbar/header di halaman Dashboard Petugas, Sidebar Header, dan Header Mahasiswa/Dosen.
  - Ikon lonceng `🔔` dengan counter angka merah `🔴`.
  - Popover Dropdown berisi daftar notifikasi terbaru, ikon kategori (📁 🔖 🔄 💸), waktu relatif (*5 menit lalu*), serta tombol *"Tandai Semua Dibaca"*.
  - Auto-refresh counter badge via AJAX setiap 30 detik secara halus.

---

## 5. Rencana Langkah Eksekusi

1. **Migrasi & Model**: Membuat file migrasi database dan Model `AppNotification`.
2. **Controller & Route API**: Membuat `NotificationController` dan route API untuk get & mark read notifications.
3. **Komponen UI**: Membuat Blade Component `resources/views/components/notification-bell.blade.php`.
4. **Integrasi Header**: Memasang komponen lonceng pada layout header Mahasiswa, Dosen, Petugas, dan Admin.
5. **Integrasi Controller Events**: Memasang pemicu `AppNotification::send()` pada seluruh controller terkait (Arsip, Booking, Loan, Return, Penalty).
6. **Pengujian**: Melakukan uji coba menyeluruh untuk semua skenario notifikasi.
