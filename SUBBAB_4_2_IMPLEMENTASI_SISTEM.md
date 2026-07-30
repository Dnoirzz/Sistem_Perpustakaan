## 4.2 Implementasi Sistem

Bagian ini menjelaskan hasil implementasi Sistem Informasi Perpustakaan berdasarkan desain yang telah dirancang, mencakup tampilan antarmuka (*user interface*), penjelasan fitur utama, serta potongan kode program yang relevan.

---

### 4.2.1 Halaman Beranda & Login Sistem

Sistem menyediakan halaman *landing page* yang dapat diakses publik sebelum masuk ke dalam sistem. Pengguna dapat melihat informasi perpustakaan, koleksi buku terbaru, dan mengakses repositori karya ilmiah. Untuk menggunakan fitur transaksional, pengguna harus login terlebih dahulu.

**Fungsi:**
- Menampilkan halaman utama perpustakaan yang dapat diakses publik.
- Menyediakan form login dan registrasi akun untuk pemustaka baru.
- Autentikasi berbasis email dan password yang divalidasi oleh Laravel middleware.

```php
// routes/web.php - Middleware Autentikasi Peran
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/mahasiswa/dashboard', [DashboardController::class, 'index']);
    // ...
});

Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/petugas/dashboard', [DashboardController::class, 'index']);
    // ...
});
```

> **Penjelasan:** Sistem menggunakan middleware berbasis role untuk memisahkan akses halaman antara Admin, Petugas, Mahasiswa, dan Dosen. Setiap role hanya dapat mengakses rute yang sesuai dengan haknya.

*(Sisipkan tangkapan layar halaman login dan landing page di sini)*

---

### 4.2.2 Fitur Manajemen Peminjaman Buku (Transaksi Sirkulasi)

Fitur ini merupakan fitur inti dari modul sirkulasi perpustakaan yang dikelola oleh Petugas Perpustakaan. Petugas dapat mencatat peminjaman buku atau karya ilmiah digital (Laporan PKL, Proposal TA, Laporan TA) kepada anggota (Mahasiswa/Dosen).

**Fungsi Utama:**
- Pencarian anggota secara *real-time* (autocomplete) berdasarkan Nama, NIM, atau NIP.
- Pencarian koleksi (buku/arsip) secara *real-time* berdasarkan judul atau jenis koleksi.
- Validasi stok koleksi sebelum transaksi dikonfirmasi.
- Pengurangan stok otomatis setelah transaksi berhasil dibuat.
- Sinkronisasi status antrian otomatis setelah transaksi dibuat.
- Pengiriman notifikasi WhatsApp otomatis ke pemustaka setelah peminjaman berhasil.

```php
// app/Http/Controllers/Petugas/LoanController.php
public function store(Request $request)
{
    // ... validasi input

    $createdLoans = DB::transaction(function () use ($validated, $koleksiIds) {
        foreach ($koleksiIds as $koleksiId) {
            // Kunci baris tabel untuk mencegah race condition
            $collection = Collection::with('book')
                ->where('koleksi_id', $koleksiId)
                ->lockForUpdate()
                ->firstOrFail();

            // Validasi stok koleksi
            if ($collection->stock < 1) {
                throw ValidationException::withMessages([
                    'koleksi_ids' => 'Stok koleksi "' . $collection->display_title . '" sudah habis.',
                ]);
            }

            // Buat transaksi peminjaman
            $newLoan = Loan::create([
                'user_id'    => $validated['user_id'],
                'koleksi_id' => $collection->koleksi_id,
                'tgl_pinjam' => $validated['tgl_pinjam'],
                'bts_waktu'  => $validated['bts_waktu'],
                'status'     => 'dipinjam',
            ]);

            // Selesaikan antrian aktif anggota untuk koleksi ini
            Antrian::where('user_id', $validated['user_id'])
                ->where('koleksi_id', $collection->koleksi_id)
                ->whereIn('status', ['menunggu', 'tersedia'])
                ->update(['status' => 'selesai']);

            // Kurangi stok koleksi secara sinkron
            $collection->syncBackingStock(-1);
        }
    });
}
```

> **Penjelasan:** Sistem menggunakan `DB::transaction()` dan `lockForUpdate()` untuk menjamin integritas data transaksi peminjaman, mencegah kondisi *race condition* apabila ada lebih dari satu petugas mengakses stok yang sama secara bersamaan.

*(Sisipkan tangkapan layar halaman daftar peminjaman dan form tambah peminjaman di sini)*

---

### 4.2.3 Fitur Pengembalian & Inspeksi Kondisi Fisik Buku

Petugas dapat memproses pengembalian buku dengan dilengkapi fitur inspeksi kondisi fisik buku menggunakan *checklist* yang dapat dikonfigurasi. Jika buku dikembalikan dalam kondisi bermasalah (rusak atau hilang), sistem secara otomatis menghitung dan mencatat sanksi/denda.

**Fungsi Utama:**
- Pengecekan kondisi fisik buku menggunakan *master checklist* (cover buku baik, halaman lengkap, bebas coretan, tidak sobek, tidak basah).
- Kalkulasi denda keterlambatan otomatis berdasarkan aturan (Rp/hari atau flat).
- Pencatatan sanksi fisik (kerusakan/kehilangan) dengan metode penyelesaian uang tunai, ganti buku, atau kombinasi.
- Pengembalian stok koleksi otomatis setelah buku dikembalikan.
- Notifikasi antrian berikutnya secara otomatis apabila buku yang dikembalikan sedang antri.

```php
// app/Http/Controllers/Petugas/ReturnController.php
private function calculateLatePenaltyAmount(PenaltyRule $rule, int $daysLate): float
{
    return match ($rule->calculation_type) {
        'per_hari' => max(1, $daysLate) * (float) $rule->default_amount,
        'flat', 'manual' => (float) $rule->default_amount,
        default => 0,
    };
}
```

> **Penjelasan:** Sistem menggunakan `match expression` PHP 8+ untuk menghitung nominal denda secara fleksibel sesuai tipe kalkulasi yang dikonfigurasi petugas (per hari, flat, atau manual).

*(Sisipkan tangkapan layar halaman proses pengembalian dan form inspeksi fisik di sini)*

---

### 4.2.4 Fitur Reservasi Buku Online (Booking)

Pemustaka (Mahasiswa/Dosen) dapat melakukan reservasi buku secara online sebelum datang ke perpustakaan untuk mengambil buku. Petugas kemudian memverifikasi dan menyetujui atau menolak booking tersebut.

**Fungsi Utama:**
- Pemustaka mengajukan booking buku secara online dari halaman katalog.
- Petugas menerima daftar booking berstatus *pending* dan dapat menyetujui (dengan menentukan batas waktu pengambilan) atau menolak permintaan.
- Booking yang disetujui otomatis mengurangi stok koleksi.
- Booking yang sudah disetujui dapat langsung direalisasikan menjadi transaksi peminjaman aktif.
- Sistem otomatis membatalkan booking yang melewati batas waktu pengambilan (*expired booking*).

```php
// app/Http/Controllers/Petugas/BookingController.php
public function approve(Request $request, $booking_id)
{
    $booking = Booking::with(['user', 'collection.book'])->findOrFail($booking_id);

    // Tetapkan batas waktu pengambilan buku
    $batasWaktu = now()->toDateString() . ' ' . $timeInput . ':00';

    DB::transaction(function () use ($booking, $batasWaktu) {
        $booking->update([
            'status'           => 'disetujui',
            'note'             => "Koleksi dapat diambil sebelum pukul {$timeInput} WIB",
            'batas_waktu_ambil' => $batasWaktu,
        ]);

        // Kurangi stok koleksi setelah booking disetujui
        $booking->collection->syncBackingStock(-1);
    });
}
```

*(Sisipkan tangkapan layar halaman daftar booking dan proses persetujuan booking di sini)*

---

### 4.2.5 Fitur Antrian Stok Kosong

Apabila stok suatu koleksi sedang habis (nol), pemustaka dapat mendaftar ke dalam antrian. Sistem secara otomatis akan memberi notifikasi WhatsApp kepada pemustaka berikutnya dalam antrian ketika buku yang ditunggu telah dikembalikan.

**Fungsi Utama:**
- Pendaftaran antrian secara mandiri oleh pemustaka dari halaman katalog.
- Penomoran antrian otomatis berdasarkan urutan pendaftaran.
- Pemustaka dapat memantau posisi antriannya (berapa orang di depannya).
- Notifikasi WhatsApp dikirim otomatis ke pemustaka berikutnya ketika buku tersedia.
- Pemustaka dapat membatalkan antriannya secara mandiri.

```php
// app/Http/Controllers/AntrianController.php
public function store(Request $request)
{
    // Hitung nomor antrian berikutnya
    $lastNo = Antrian::where('koleksi_id', $koleksiId)
        ->whereIn('status', ['menunggu', 'tersedia'])
        ->max('no_antrian') ?? 0;

    $nextNo = $lastNo + 1;

    Antrian::create([
        'user_id'    => $user->user_id,
        'koleksi_id' => $koleksiId,
        'no_antrian' => $nextNo,
        'status'     => 'menunggu',
    ]);

    return back()->with('success', 'Anda berhasil masuk antrian! Nomor antrian Anda: ' . $nextNo);
}
```

*(Sisipkan tangkapan layar halaman antrian anggota di sini)*

---

### 4.2.6 Fitur Manajemen Denda & Sanksi (Penalties)

Petugas dapat mengelola denda dan sanksi yang dikenakan kepada pemustaka. Sistem mendukung tiga jenis sanksi, yaitu keterlambatan (dihitung otomatis), kerusakan, dan kehilangan buku.

**Fungsi Utama:**
- Kalkulasi denda keterlambatan otomatis berdasarkan rule yang dikonfigurasi di `penalty_rules`.
- Pencatatan sanksi fisik (kerusakan/kehilangan) secara manual oleh petugas.
- Tiga metode penyelesaian: uang tunai, ganti buku, atau kombinasi.
- Penandaan denda sebagai lunas oleh petugas setelah dibayarkan.
- Dashboard ringkasan status denda anggota.

*(Sisipkan tangkapan layar halaman daftar denda/sanksi pemustaka di sini)*

---

### 4.2.7 Fitur Repositori Arsip Digital (PKL & Tugas Akhir)

Sistem menyediakan repositori digital untuk karya ilmiah mahasiswa, mencakup Laporan PKL, Proposal TA, dan Laporan Tugas Akhir. Mahasiswa dapat mengunggah dokumen, kemudian petugas memverifikasinya sebelum dapat diakses publik.

**Fungsi Utama:**
- Mahasiswa mengunggah dokumen (PDF/Word) melalui halaman dashboard masing-masing.
- Petugas memverifikasi dokumen dan mengubah statusnya (`pending` → `diverifikasi` → `aktif` atau `ditolak`).
- Sistem menghasilkan nomor surat tanda terima secara otomatis.
- Dokumen yang aktif dapat dibaca secara online oleh semua pemustaka (preview PDF).
- Sistem mencatat riwayat pembacaan arsip digital pada tabel `archive_read_logs`.
- Seluruh arsip digital juga diintegrasikan ke sistem peminjaman melalui tabel `collections` (polimorfik).

*(Sisipkan tangkapan layar halaman repositori digital dan halaman verifikasi arsip di sini)*

---

### 4.2.8 Fitur Usulan & Voting Pengadaan Buku

Pemustaka dapat mengusulkan judul buku baru yang ingin diadakan oleh perpustakaan. Petugas kemudian dapat membuka sesi voting dari usulan-usulan yang masuk, sehingga pemustaka bisa memilih buku prioritas pengadaan secara demokratis.

**Fungsi Utama:**
- Mahasiswa/Dosen mengusulkan judul buku beserta alasan melalui fitur Rekomendasi Buku.
- Petugas membuat sesi Voting dengan menentukan tanggal mulai dan tanggal selesai.
- Petugas memilih usulan mana yang masuk dalam sesi voting tersebut (*voting items*).
- Mahasiswa/Dosen memberikan suara untuk buku yang diprioritaskan (1 user = 1 suara per item).
- Petugas dapat memantau hasil rekapitulasi suara secara *real-time*.

*(Sisipkan tangkapan layar halaman usulan buku dan halaman voting di sini)*

---

### 4.2.9 Fitur Notifikasi WhatsApp Otomatis

Sistem terintegrasi dengan layanan **Fonnte WhatsApp Gateway API** untuk mengirimkan pesan notifikasi otomatis kepada pemustaka. Notifikasi ini memperkuat komunikasi antara perpustakaan dan pemustaka secara efisien.

**Jenis Notifikasi yang Dikirim:**
| No | Peristiwa | Penerima | Keterangan |
| :---: | :--- | :--- | :--- |
| 1 | Peminjaman berhasil dibuat | Peminjam | Konfirmasi judul & batas waktu pengembalian |
| 2 | Pengingat H-1 jatuh tempo | Peminjam | Dikirim otomatis via Laravel Scheduler |
| 3 | Status buku terlambat | Peminjam | Dikirim otomatis via Laravel Scheduler |
| 4 | Antrian tersedia (buku kembali) | Pemustaka dalam antrian | Notifikasi otomatis setelah buku dikembalikan |

```php
// app/Services/WhatsAppService.php (Contoh pengiriman)
// app/Http/Controllers/Petugas/LoanController.php
\App\Services\WhatsAppService::send(
    $member->no_hp,
    "Halo, {$namaAnggota}! 📚\n\n" .
    "Peminjaman buku baru Anda telah berhasil dicatat.\n\n" .
    "• Judul Buku: *{$judulBuku}*\n" .
    "• Batas Pengembalian: *{$btsWaktu}*\n\n" .
    "Terima kasih — {$senderName}"
);
```

```php
// app/Console/Commands/SendLoanReminderNotifications.php
// Dijadwalkan lewat Laravel Scheduler (misal: artisan schedule:run)
protected $signature   = 'loans:send-reminders';
protected $description = 'Kirim notifikasi pengingat H-1 jatuh tempo dan status terlambat via WhatsApp';
```

> **Penjelasan:** Scheduler Laravel menjalankan perintah `loans:send-reminders` secara otomatis setiap hari untuk mengirimkan pengingat kepada pemustaka yang buku pinjamannya hampir jatuh tempo (H-1) maupun sudah melewati batas pengembalian.

*(Sisipkan tangkapan layar halaman pengaturan WhatsApp dan contoh pesan WhatsApp yang dikirim di sini)*

---

### 4.2.10 Fitur Dashboard & Laporan Statistik

Sistem menyediakan dashboard yang informatif untuk setiap peran pengguna, menampilkan data statistik real-time mengenai aktivitas perpustakaan.

**Fungsi Utama Dashboard Petugas:**
- Total peminjaman aktif & terlambat saat ini.
- Jumlah buku yang dikembalikan hari ini.
- Total stok koleksi yang tersedia.
- Daftar peminjaman terbaru dan antrian aktif.

**Fungsi Utama Dashboard Mahasiswa:**
- Status peminjaman aktif milik mahasiswa.
- Daftar antrian buku yang sedang diikuti.
- Riwayat peminjaman dan denda.

```php
// app/Http/Controllers/Petugas/LoanController.php
$stats = [
    'active_loans'    => Loan::whereIn('status', ['dipinjam', 'terlambat'])->count(),
    'overdue_loans'   => Loan::where('status', 'terlambat')->count(),
    'returned_today'  => Loan::whereDate('tgl_kembali', today())->count(),
    'available_books' => Collection::sum('stock'),
];
```

*(Sisipkan tangkapan layar halaman dashboard Petugas dan Mahasiswa di sini)*
