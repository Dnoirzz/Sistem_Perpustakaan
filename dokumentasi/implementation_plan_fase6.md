# Fase 6 — Notifikasi WhatsApp (WA Notification) ✅ DISETUJUI

Sistem notifikasi WhatsApp otomatis yang dikirim ke anggota (Mahasiswa/Dosen) pada event-event kritis sirkulasi perpustakaan. API Token Fonnte dikelola langsung dari halaman **Pengaturan Admin** di UI — tidak perlu buka file `.env` atau code.

---

## Keputusan Final

| Aspek | Keputusan |
|---|---|
| **Provider** | ✅ Fonnte (sudah punya akun & token) |
| **Mode Pengiriman** | ✅ Sinkron + `try-catch` (gagal → log, tidak error UI) |
| **Konfigurasi Token** | ✅ Dikelola via halaman Pengaturan Admin di UI |
| **Event Prioritas** | ✅ 4 event (lihat tabel di bawah) |

> [!NOTE]
> Field `no_hp` sudah ada di tabel `users`. Jika kosong, notifikasi di-skip secara diam-diam dan dicatat di log Laravel — tidak mengganggu operasi utama.

---

## Event Notifikasi (4 Prioritas)

| # | Event | Penerima | Trigger Di | Tipe |
|---|---|---|---|---|
| 1 | **Pinjaman Baru Dicatat** | Anggota | `LoanController@store` | Sinkron |
| 2 | **Pengingat H-1 Jatuh Tempo** | Anggota | Scheduled Command | Terjadwal |
| 3 | **Status Terlambat** | Anggota | Scheduled Command | Terjadwal |
| 4 | **Antrian Tersedia** | Anggota yang antre | `ReturnController@process` | Sinkron |

> [!NOTE]
> Event 2 & 3 butuh **Laravel Scheduler**. Event 1 & 4 dipanggil langsung dari controller (sinkron).

---

## Proposed Changes

### 1. Tabel Pengaturan Aplikasi (App Settings)

#### [NEW] Migration: `create_app_settings_table`
Tabel key-value generik untuk menyimpan pengaturan sistem:
```
app_settings: id | key | value | description | created_at | updated_at
```
Baris awal yang di-seed:
- `fonnte_token` → `''`
- `wa_notification_enabled` → `true`
- `wa_sender_name` → `'Perpustakaan PSDKU POLNEP'`

#### [NEW] `app/Models/AppSetting.php`
Model dengan helper statis `AppSetting::get('key')` dan `AppSetting::set('key', 'value')`.

---

### 2. Halaman Pengaturan WA Admin

#### [NEW] `app/Http/Controllers/Admin/SettingController.php`
- `index()` — tampilkan form pengaturan WA (token, on/off toggle)
- `update()` — simpan perubahan ke tabel `app_settings`
- `testWa()` — kirim pesan WA uji coba ke nomor yang dimasukkan admin (fitur test connection)

#### [NEW] `resources/views/admin/settings/index.blade.php`
Halaman pengaturan WA dengan desain premium (konsisten dengan admin dashboard):
- Toggle aktif/nonaktif notifikasi WA
- Input Fonnte API Token (tersembunyi/masked, ada tombol show/hide)
- Input nama pengirim
- Tombol **"Uji Koneksi"** → kirim WA test ke nomor yang dimasukkan
- Badge status koneksi (Connected / Not Configured)

#### [MODIFY] Sidebar [admin/dashboard.blade.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/resources/views/admin/dashboard.blade.php)
Tambah menu **"Pengaturan WA"** di sidebar admin.

#### [MODIFY] [routes/web.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/routes/web.php)
Tambah route admin untuk `settings`:
```php
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
Route::post('/settings/test-wa', [SettingController::class, 'testWa'])->name('settings.test-wa');
```

---

### 3. Service & Konfigurasi

#### [NEW] `app/Services/WhatsAppService.php`
Service class terpusat. Token dibaca **dari database** (`AppSetting::get('fonnte_token')`) bukan dari `.env`:
```php
WhatsAppService::send(string $phone, string $message): bool
WhatsAppService::isEnabled(): bool  
```
Semua pengiriman dibungkus `try-catch`. Jika gagal → `Log::warning(...)`, tidak throw exception.

---

### 4. Notifikasi Sinkron

#### [MODIFY] [LoanController.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/app/Http/Controllers/Petugas/LoanController.php)
- Setelah `store()` berhasil: kirim WA konfirmasi pinjaman ke anggota.

#### [MODIFY] [ReturnController.php](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/app/Http/Controllers/Petugas/ReturnController.php)
- Setelah buku dikembalikan & ada antrian: kirim WA notifikasi "Antrian Tersedia" ke anggota pertama di antrian.

---

### 5. Notifikasi Terjadwal (Laravel Scheduler)

#### [NEW] `app/Console/Commands/SendLoanReminderNotifications.php`
Artisan command `php artisan loans:send-reminders`:
- **H-1 Jatuh Tempo**: Cari loan `bts_waktu = tomorrow()` + status `dipinjam` → kirim WA reminder.
- **Terlambat**: Cari loan status `terlambat` → kirim WA peringatan denda.

#### [MODIFY] `routes/console.php`
Daftarkan schedule harian jam 08:00 WIB.

---

### 4. Template Pesan WA

Pesan WA dibuat dalam bahasa Indonesia yang ramah dan informatif. Contoh template:

**Booking Disetujui:**
```
Halo, {nama}! 📚
Booking buku *{judul_buku}* Anda telah *DISETUJUI*.
Silakan ambil buku di perpustakaan sebelum pukul *{batas_waktu}*.
Terima kasih — Perpustakaan PSDKU POLNEP Sukamara
```

**Pengingat H-1:**
```
Halo, {nama}! ⏰
Ini pengingat bahwa batas pengembalian buku *{judul_buku}* adalah besok, *{tanggal}*.
Mohon kembalikan tepat waktu untuk menghindari denda.
Terima kasih — Perpustakaan PSDKU POLNEP Sukamara
```

---

## Verification Plan

### Automated / Manual Testing
- Uji `WhatsAppService::send()` via `php artisan tinker` dengan nomor WA yang valid.
- Uji setiap event controller dengan simulasi aksi di UI.
- Uji command scheduler via `php artisan send:loan-reminders`.

### Manual Verification
- Pastikan pesan WA diterima di nomor HP anggota uji coba.
- Pastikan tidak ada error saat `no_hp` kosong (graceful fallback dengan log warning).
- Cek log Laravel untuk memastikan request ke Fonnte API tercatat.
