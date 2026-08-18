# Panduan Penempatan Potongan Kode Bab IV

Dokumen ini berisi lokasi penyisipan potongan kode pada Bab IV laporan tugas akhir, contoh kode yang dapat digunakan, dan penjelasan singkatnya. Potongan kode diambil dari implementasi proyek sehingga perlu disesuaikan kembali jika terdapat perubahan pada source code.

## Pola penulisan yang digunakan

Setiap potongan kode sebaiknya ditulis dengan urutan berikut:

1. Jelaskan terlebih dahulu fungsi fitur.
2. Tampilkan gambar antarmuka yang berkaitan.
3. Jelaskan alur kerja fitur.
4. Tambahkan judul kode, misalnya **Kode 4.1 Implementasi Proses Peminjaman Buku**.
5. Tampilkan potongan kode.
6. Tambahkan penjelasan singkat mengenai kode tersebut.

Gunakan font `Consolas` atau `Courier New` dengan ukuran 9--10 pt agar kode mudah dibaca. Kode lengkap tidak perlu dimasukkan seluruhnya; cukup bagian yang menunjukkan logika utama fitur.

## 1. Login dan pembatasan hak akses

### Lokasi penempatan di laporan

Tempatkan pada subbab **Implementasi Halaman Login dan Hak Akses**, setelah paragraf penjelasan **Gambar 4.4 Tampilan Halaman Login** dan sebelum subbab **Implementasi Sistem Admin**.

### Judul kode

**Kode 4.1 Implementasi Pembatasan Hak Akses Berdasarkan Role**

### Sumber kode

`routes/web.php`

### Kata pembuka sebelum kode

Proses pembatasan hak akses pada sistem diimplementasikan menggunakan middleware `auth` dan `role`. Middleware tersebut digunakan untuk memastikan bahwa pengguna yang telah login hanya dapat mengakses halaman sesuai dengan hak aksesnya. Potongan kode pembatasan akses halaman berdasarkan role ditunjukkan pada Kode 4.1.

### Potongan kode

```php
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [
            AdminDashboard::class,
            'index'
        ])->name('dashboard');
    });

Route::middleware(['auth', 'role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {
        Route::get('/dashboard', [
            PetugasDashboard::class,
            'index'
        ])->name('dashboard');
    });
```

### Penjelasan

Kode tersebut menggunakan middleware `auth` dan `role` untuk membatasi akses halaman. Pengguna harus sudah login dan hanya dapat mengakses halaman sesuai dengan perannya, seperti admin atau petugas.

## 2. Proses peminjaman buku

### Lokasi penempatan di laporan

Tempatkan pada bagian **Implementasi Manajemen Peminjaman**, setelah paragraf penjelasan **Gambar 4.33 Halaman Buat Transaksi Peminjaman** dan sebelum bagian **Halaman Pengembalian Buku**.

### Judul kode

**Kode 4.2 Implementasi Proses Peminjaman Buku**

### Sumber kode

`app/Http/Controllers/Petugas/LoanController.php`

### Kata pembuka sebelum kode

Proses peminjaman buku dilakukan oleh petugas melalui halaman transaksi peminjaman. Sebelum transaksi disimpan, sistem memeriksa ketersediaan stok dan memastikan anggota tidak memiliki peminjaman aktif untuk koleksi yang sama. Implementasi proses peminjaman tersebut ditunjukkan pada Kode 4.2.

### Potongan kode

```php
$createdLoans = DB::transaction(function () use (
    $validated,
    $koleksiIds
) {
    $loans = [];

    foreach ($koleksiIds as $koleksiId) {
        $collection = Collection::with('book')
            ->where('koleksi_id', $koleksiId)
            ->lockForUpdate()
            ->firstOrFail();

        if ($collection->stock < 1) {
            throw ValidationException::withMessages([
                'koleksi_ids' => 'Stok koleksi sudah habis.'
            ]);
        }

        $newLoan = Loan::create([
            'user_id' => $validated['user_id'],
            'koleksi_id' => $collection->koleksi_id,
            'tgl_pinjam' => $validated['tgl_pinjam'],
            'bts_waktu' => $validated['bts_waktu'],
            'status' => 'dipinjam',
        ]);

        Antrian::where('user_id', $validated['user_id'])
            ->where('koleksi_id', $collection->koleksi_id)
            ->whereIn('status', ['menunggu', 'tersedia'])
            ->update(['status' => 'selesai']);

        $collection->syncBackingStock(-1);
        $loans[] = $newLoan;
    }

    return $loans;
});
```

### Penjelasan

Kode tersebut menjalankan proses peminjaman dalam `DB::transaction()`. Sistem memeriksa stok koleksi sebelum transaksi disimpan. Jika stok tersedia, data peminjaman dibuat, status antrian anggota diselesaikan, dan stok koleksi dikurangi. `lockForUpdate()` digunakan untuk menjaga konsistensi stok ketika terdapat transaksi secara bersamaan.

## 3. Proses pengembalian dan perhitungan denda

### Lokasi penempatan di laporan

Tempatkan pada bagian **Halaman Pengembalian Buku**, setelah paragraf penjelasan **Gambar 4.35 Tampilan Form Inspeksi Pengembalian Buku** dan sebelum bagian **Halaman Booking Buku**.

### Judul kode

**Kode 4.3 Implementasi Pengembalian Koleksi dan Perhitungan Denda**

### Sumber kode

`app/Http/Controllers/Petugas/ReturnController.php`

### Kata pembuka sebelum kode

Proses pengembalian buku meliputi perubahan status transaksi, penyimpanan hasil pemeriksaan kondisi fisik, pembaruan stok, dan perhitungan denda apabila terjadi keterlambatan. Potongan kode proses pengembalian dan perhitungan denda ditunjukkan pada Kode 4.3.

### Potongan kode

```php
$loan->update([
    'tgl_kembali' => $today,
    'status' => 'dikembalikan',
    'return_condition_status' => $hasPhysicalIssue
        ? 'bermasalah'
        : 'baik',
    'return_condition_checks' => $conditionChecks,
    'return_condition_notes' => $request->input(
        'return_condition_notes'
    ),
]);

if ($shouldRestock && $collection) {
    $collection->syncBackingStock(1);
}

if ($wasOverdue && $lateRule && $lateRule->is_active) {
    $daysLate = $loan->bts_waktu->diffInDays($today);
    $amount = $this->calculateLatePenaltyAmount(
        $lateRule,
        $daysLate
    );
}
```

### Potongan kode perhitungan denda

```php
private function calculateLatePenaltyAmount(
    PenaltyRule $rule,
    int $daysLate
): float {
    return match ($rule->calculation_type) {
        'per_hari' => max(1, $daysLate)
            * (float) $rule->default_amount,
        'flat', 'manual' => (float) $rule->default_amount,
        default => 0,
    };
}
```

### Penjelasan

Kode tersebut mengubah status peminjaman menjadi `dikembalikan`, menyimpan hasil pemeriksaan kondisi fisik, dan menambah kembali stok koleksi. Jika peminjaman terlambat, sistem menghitung denda berdasarkan aturan yang aktif, yaitu per hari, flat, atau manual.

## 4. Persetujuan booking buku

### Lokasi penempatan di laporan

Tempatkan pada bagian **Halaman Booking Buku**, setelah paragraf penjelasan **Gambar 4.37 Tampilan Form Persetujuan Booking**. Kode dapat ditempatkan sebelum penjelasan **Gambar 4.38 Tampilan Form Penolakan Booking**.

### Judul kode

**Kode 4.4 Implementasi Persetujuan Booking Buku**

### Sumber kode

`app/Http/Controllers/Petugas/BookingController.php`

### Kata pembuka sebelum kode

Persetujuan booking dilakukan setelah petugas memeriksa status booking dan ketersediaan stok koleksi. Apabila syarat terpenuhi, sistem mengubah status booking, menyimpan batas waktu pengambilan, dan mengurangi stok koleksi. Proses tersebut ditunjukkan pada Kode 4.4.

### Potongan kode

```php
$result = DB::transaction(function () use (
    $booking_id,
    $batasWaktu,
    $request,
    $timeInput
) {
    $booking = Booking::query()
        ->whereKey($booking_id)
        ->lockForUpdate()
        ->firstOrFail();

    if ($booking->status !== 'pending') {
        return [
            'error' => 'Booking sudah diproses sebelumnya.'
        ];
    }

    $collection = Collection::query()
        ->whereKey($booking->koleksi_id)
        ->lockForUpdate()
        ->first();

    if (! $collection || $collection->stock < 1) {
        return [
            'error' => 'Stok koleksi tidak mencukupi.'
        ];
    }

    $booking->update([
        'status' => 'disetujui',
        'note' => $request->input('note')
            ?? "Koleksi dapat diambil sebelum pukul {$timeInput} WIB",
        'batas_waktu_ambil' => $batasWaktu,
    ]);

    $collection->syncBackingStock(-1);

    return [
        'booking' => $booking->load(['user', 'collection.book']),
    ];
});
```

### Penjelasan

Kode tersebut memeriksa status booking dan ketersediaan stok sebelum booking disetujui. Jika memenuhi syarat, status booking diubah menjadi `disetujui`, batas waktu pengambilan disimpan, dan stok koleksi dikurangi secara atomik.

## 5. Verifikasi arsip digital

### Lokasi penempatan di laporan

Tempatkan pada bagian **Implementasi Kelola Arsip Digital**, setelah paragraf penjelasan Gambar 4.22 yang menjelaskan proses verifikasi dan pembuatan surat tanda terima, sebelum bagian **Gambar 4.23 Halaman Import Arsip**.

### Judul kode

**Kode 4.5 Implementasi Verifikasi Arsip Digital**

### Sumber kode

`app/Http/Controllers/Petugas/ArsipController.php`

### Kata pembuka sebelum kode

Verifikasi arsip digital dilakukan oleh petugas terhadap arsip yang berstatus `pending`. Setelah arsip dinyatakan memenuhi persyaratan, sistem mengubah status arsip, membuat surat tanda terima, dan menyimpan nomor surat serta lokasi file PDF. Implementasi proses verifikasi ditunjukkan pada Kode 4.5.

### Potongan kode

```php
public function verify(string $type, int $id)
{
    $archive = ArsipDigital::findOrFail(
        $type,
        $id,
        ['mahasiswa.user', 'mahasiswa.prodi']
    );

    if ($archive->status !== ArsipDigital::STATUS_PENDING) {
        return back()->with(
            'error',
            'Hanya arsip pending yang dapat diverifikasi.'
        );
    }

    DB::transaction(function () use ($archive) {
        $archive->update([
            'status' => ArsipDigital::STATUS_DIVERIFIKASI,
            'catatan_petugas' => null,
            'verified_at' => now(),
        ]);

        $result = $this->suratTandaTerimaService->generate(
            $archive->fresh(['mahasiswa.user', 'mahasiswa.prodi'])
        );

        $archive->update([
            'surat_tanda_terima_pdf' => $result['path'],
            'nomor_surat' => $result['nomor_surat'],
            'verified_at' => $result['verified_at'],
        ]);
    });
}
```

### Penjelasan

Kode tersebut hanya mengizinkan arsip berstatus `pending` untuk diverifikasi. Setelah status diubah menjadi `diverifikasi`, sistem membuat surat tanda terima dan menyimpan lokasi file PDF serta nomor surat ke database.

## 6. Pengiriman notifikasi otomatis

### Lokasi penempatan di laporan

Tempatkan pada bagian **Implementasi Menu Pengaturan Sistem**, setelah penjelasan pengaturan WhatsApp atau Telegram dan sebelum bagian **Implementasi Log Aktivitas**.

### Judul kode

**Kode 4.6 Implementasi Pengiriman Notifikasi WhatsApp**

### Sumber kode

`app/Services/WhatsAppService.php`

### Kata pembuka sebelum kode

Sistem menyediakan notifikasi WhatsApp untuk menyampaikan informasi peminjaman dan pengingat jatuh tempo kepada anggota. Pengiriman pesan dilakukan melalui Fonnte API setelah sistem memeriksa status fitur, token API, dan nomor telepon penerima. Potongan kode pengiriman notifikasi ditunjukkan pada Kode 4.6.

### Potongan kode

```php
public static function send(string $phone, string $message): bool
{
    if (!self::isEnabled()) {
        Log::info(
            'Pengiriman WhatsApp dinonaktifkan.'
        );
        return false;
    }

    $token = AppSetting::get('fonnte_token');

    if (empty($token) || empty($phone)) {
        return false;
    }

    $formattedPhone = self::formatPhoneNumber($phone);

    $response = Http::withHeaders([
        'Authorization' => $token,
    ])->timeout(10)->post(
        'https://api.fonnte.com/send',
        [
            'target' => $formattedPhone,
            'message' => $message,
        ]
    );

    return $response->successful();
}
```

### Penjelasan

Kode tersebut memeriksa status fitur notifikasi dan ketersediaan token sebelum mengirim pesan ke Fonnte API. Nomor telepon dinormalisasi, kemudian sistem mengirimkan pesan melalui HTTP request.

### Penjadwalan notifikasi

Tambahkan potongan berikut setelah Kode 4.6 jika ingin menjelaskan pengingat jatuh tempo otomatis.

**Kode 4.7 Penjadwalan Pengingat Jatuh Tempo**

Sumber: `routes/console.php`

Sistem menjalankan perintah pengiriman pengingat secara otomatis menggunakan Laravel Scheduler. Jadwal pelaksanaan perintah tersebut ditunjukkan pada Kode 4.7.

```php
Schedule::command('loans:send-reminders')
    ->dailyAt('10:33');
```

Perintah yang dijadwalkan tersebut didefinisikan pada `app/Console/Commands/SendLoanReminderNotifications.php` dengan signature berikut:

```php
protected $signature = 'loans:send-reminders';
```

Kode tersebut membuat Laravel menjalankan perintah pengiriman pengingat secara otomatis setiap hari pada waktu yang telah ditentukan.

## 7. Dashboard dan statistik sistem (opsional)

### Lokasi penempatan di laporan

Tempatkan setelah paragraf penjelasan **Gambar 4.16 Tampilan Dashboard Petugas** jika jumlah potongan kode masih perlu ditambah.

### Judul kode

**Kode 4.8 Implementasi Perhitungan Statistik Dashboard**

### Contoh kode

Data yang ditampilkan pada dashboard diperoleh melalui proses perhitungan jumlah transaksi dan stok koleksi dari database. Potongan kode perhitungan statistik dashboard ditunjukkan pada Kode 4.8.

```php
$stats = [
    'active_loans' => Loan::whereIn(
        'status',
        ['dipinjam', 'terlambat']
    )->count(),
    'overdue_loans' => Loan::where(
        'status',
        'terlambat'
    )->count(),
    'returned_today' => Loan::whereDate(
        'tgl_kembali',
        today()
    )->count(),
    'available_books' => Collection::sum('stock'),
];
```

### Penjelasan

Kode tersebut mengambil data statistik dari database untuk ditampilkan pada dashboard, seperti jumlah peminjaman aktif, peminjaman terlambat, buku yang dikembalikan hari ini, dan stok koleksi yang tersedia.

## Rekomendasi akhir

Untuk memenuhi revisi penguji, gunakan minimal Kode 4.1 sampai Kode 4.5. Kode 4.6 sampai Kode 4.8 dapat ditambahkan jika ingin menjelaskan fitur notifikasi dan dashboard secara lebih lengkap.

Jangan menampilkan token API, password, atau data rahasia lain di dalam laporan. Sebelum memasukkan kode ke Word, pastikan kembali bahwa kode yang ditampilkan masih sama dengan source code terbaru.
