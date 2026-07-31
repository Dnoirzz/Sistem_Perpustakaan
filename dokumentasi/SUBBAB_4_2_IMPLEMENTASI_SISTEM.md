## 4.2 Implementasi Sistem

Implementasi sistem merupakan tahap penerapan dari hasil perancangan yang telah dibuat pada Bab III. Pada tahap ini, rancangan basis data, rancangan antarmuka, serta alur proses sistem direalisasikan ke dalam aplikasi Sistem Informasi Perpustakaan. Implementasi sistem ditampilkan melalui tangkapan layar antarmuka dan penjelasan fungsi dari setiap fitur utama yang telah dikembangkan.

Sistem Informasi Perpustakaan ini memiliki tiga kelompok pengguna utama, yaitu admin, petugas, dan anggota. Kelompok anggota terdiri dari mahasiswa dan dosen. Setiap kelompok pengguna memiliki hak akses dan tampilan menu yang berbeda sesuai dengan perannya masing-masing. Admin berfokus pada pengelolaan data pengguna dan pengaturan sistem, petugas berfokus pada kegiatan operasional perpustakaan, sedangkan anggota berfokus pada penggunaan layanan perpustakaan seperti katalog buku, booking, antrian, peminjaman, usulan buku, voting, dan akses arsip digital.

### 4.2.1 Implementasi Halaman Beranda Sistem

Halaman beranda merupakan halaman awal yang ditampilkan ketika pengguna mengakses Sistem Informasi Perpustakaan. Halaman ini dapat diakses tanpa melakukan login terlebih dahulu. Pada halaman beranda ditampilkan informasi umum perpustakaan, jumlah koleksi buku, jumlah anggota, jumlah arsip digital, serta daftar buku terbaru yang tersedia di sistem.

[Sisipkan Gambar 4.1 Halaman Beranda Sistem]

Pada Gambar 4.1 ditampilkan halaman beranda Sistem Informasi Perpustakaan. Halaman ini berfungsi sebagai halaman pengenalan sistem sekaligus pintu masuk menuju halaman login dan registrasi. Selain itu, halaman ini juga memberikan gambaran umum mengenai koleksi dan layanan yang tersedia pada perpustakaan.

Implementasi halaman beranda dilakukan melalui route utama aplikasi. Sistem mengambil data jumlah buku, jumlah anggota, jumlah arsip, dan data buku terbaru dari basis data, kemudian menampilkannya pada halaman beranda.

```php
Route::get('/', function () {
    $totalBooks = \App\Models\Book::count();
    $totalMembers = \App\Models\User::whereHas('role', function ($query) {
        $query->whereIn('role_name', ['mahasiswa', 'dosen']);
    })->count();
    $totalArchives = \App\Models\LaporanPkl::count()
        + \App\Models\LaporanTugasAkhir::count()
        + \App\Models\ProposalTa::count();

    $featuredBooks = \App\Models\Book::with(['category', 'collection'])
        ->latest()
        ->take(10)
        ->get();

    return view('welcome', compact(
        'totalBooks',
        'totalMembers',
        'totalArchives',
        'featuredBooks'
    ));
})->name('welcome');
```

Potongan kode tersebut menunjukkan proses pengambilan data ringkasan untuk halaman beranda. Data yang telah diambil kemudian dikirim ke view `welcome` agar dapat ditampilkan kepada pengguna.

### 4.2.2 Implementasi Halaman Registrasi

Halaman registrasi digunakan oleh pengguna baru untuk membuat akun sebagai anggota perpustakaan. Pada sistem ini, registrasi ditujukan untuk mahasiswa dan dosen. Pengguna mahasiswa harus mengisi data nama, email, password, nomor handphone, program studi, NIM, dan semester. Sementara itu, pengguna dosen mengisi data nama, email, password, nomor handphone, program studi, dan NIP.

[Sisipkan Gambar 4.2 Halaman Registrasi]

Pada Gambar 4.2 ditampilkan halaman registrasi anggota perpustakaan. Halaman ini menyediakan form pendaftaran akun dan data profil anggota. Setelah data berhasil disimpan, pengguna dapat melakukan login menggunakan email dan password yang telah didaftarkan.

Proses registrasi membedakan data profil berdasarkan jenis pengguna. Jika pengguna memilih role mahasiswa, maka sistem menyimpan data ke tabel `mahasiswas`. Jika pengguna memilih role dosen, maka sistem menyimpan data ke tabel `dosens`.

```php
if ($request->role_name === 'mahasiswa') {
    $rules['nim'] = ['required', 'string', 'max:50', 'unique:mahasiswas,nim'];
    $rules['semester'] = ['required', 'string', 'max:10'];
} else {
    $rules['nip'] = ['required', 'string', 'max:50', 'unique:dosens,nip'];
}

$user = User::create([
    'role_id' => $role->role_id,
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'no_hp' => $request->no_hp,
]);
```

Potongan kode tersebut menunjukkan bahwa sistem melakukan validasi berbeda berdasarkan role yang dipilih. Password pengguna disimpan dalam bentuk terenkripsi menggunakan fungsi `Hash::make()` sehingga tidak tersimpan dalam bentuk teks asli.

### 4.2.3 Implementasi Halaman Login dan Hak Akses

Halaman login digunakan oleh pengguna untuk masuk ke dalam sistem menggunakan email dan password yang telah terdaftar. Tampilan halaman login dirancang dengan dua bagian utama. Bagian kiri menampilkan identitas Sistem Informasi Perpustakaan berupa logo POLNEP, nama aplikasi "SIPUS PSDKU POLNEP", dan keterangan bahwa sistem digunakan untuk akses pustaka digital serta layanan akademik Sukamara dalam satu platform terpadu. Bagian kanan menampilkan form login yang digunakan untuk proses autentikasi pengguna.

[Sisipkan Gambar 4.3 Halaman Login]

Pada Gambar 4.3 ditampilkan halaman login Sistem Informasi Perpustakaan. Halaman ini memiliki tombol "Kembali ke Beranda" yang digunakan untuk kembali ke halaman awal sistem. Form login terdiri dari input email, input password, tombol untuk menampilkan atau menyembunyikan password, pilihan "Ingat saya", tautan "Lupa Password?", tombol "Masuk", serta tautan "Daftar Sekarang" bagi pengguna yang belum memiliki akun.

Proses login dilakukan dengan memvalidasi email dan password pengguna. Jika data yang dimasukkan sesuai, sistem akan membuat session pengguna dan mengarahkan pengguna ke dashboard berdasarkan role masing-masing. Setelah login berhasil, sistem juga mencatat aktivitas login ke tabel log aktivitas.

```php
public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    \App\Models\ActivityLog::create([
        'user_id' => Auth::id(),
        'activity' => 'Melakukan login ke sistem',
    ]);

    return redirect()->intended(route('dashboard', absolute: false));
}
```

Potongan kode tersebut menunjukkan proses autentikasi pengguna. Setelah proses login berhasil, sistem mencatat aktivitas login dan mengarahkan pengguna ke route dashboard.

Setelah pengguna berhasil login, sistem memeriksa role pengguna untuk menentukan halaman dashboard yang akan ditampilkan. Pengguna admin diarahkan ke dashboard admin, petugas diarahkan ke dashboard petugas, dosen diarahkan ke dashboard dosen, dan mahasiswa diarahkan ke dashboard mahasiswa.

```php
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isPetugas()) {
        return redirect()->route('petugas.dashboard');
    } elseif ($user->isDosen()) {
        return redirect()->route('dosen.dashboard');
    } elseif ($user->isMahasiswa()) {
        return redirect()->route('mahasiswa.dashboard');
    }

    abort(403, 'Role tidak dikenali.');
})->middleware(['auth'])->name('dashboard');
```

Potongan kode tersebut menunjukkan pembagian dashboard berdasarkan role. Dengan pembagian ini, setiap pengguna hanya dapat mengakses fitur yang sesuai dengan hak aksesnya.

### 4.2.4 Implementasi Sistem pada Admin

Admin merupakan pengguna yang memiliki hak akses untuk mengelola data utama dan pengaturan sistem. Menu yang tersedia pada admin meliputi dashboard, kelola user, kelola prodi dan jurusan, pengaturan notifikasi, pengaturan template tanda terima, log aktivitas, dan profil.

[Sisipkan Gambar 4.4 Dashboard Admin]

Pada Gambar 4.4 ditampilkan dashboard admin. Dashboard admin menampilkan ringkasan jumlah pengguna, jumlah mahasiswa, jumlah dosen, jumlah petugas, data pengguna terbaru, grafik tren peminjaman, dan distribusi kategori buku terpopuler.

#### a. Implementasi Menu Kelola User

Menu kelola user digunakan oleh admin untuk mengelola akun pengguna sistem. Melalui menu ini admin dapat menambahkan, mengubah, menghapus, dan mengimpor data pengguna. Data pengguna yang dikelola meliputi akun admin, petugas, mahasiswa, dan dosen.

[Sisipkan Gambar 4.5 Halaman Kelola User]

Pada Gambar 4.5 ditampilkan halaman kelola user. Halaman ini menampilkan daftar pengguna beserta informasi role, nama, email, dan tombol aksi. Fitur import user juga disediakan untuk mempercepat proses input data pengguna dalam jumlah banyak.

#### b. Implementasi Menu Kelola Prodi dan Jurusan

Menu kelola prodi dan jurusan digunakan untuk mengelola data struktur akademik yang digunakan pada profil mahasiswa dan dosen. Data jurusan berfungsi sebagai induk dari data program studi.

[Sisipkan Gambar 4.6 Halaman Kelola Prodi dan Jurusan]

Pada Gambar 4.6 ditampilkan halaman pengelolaan prodi dan jurusan. Data ini digunakan ketika pengguna mahasiswa atau dosen melakukan registrasi dan ketika admin atau petugas mengelola data anggota.

#### c. Implementasi Menu Pengaturan Sistem

Menu pengaturan digunakan oleh admin untuk mengatur konfigurasi sistem, seperti notifikasi WhatsApp, notifikasi email, dan template surat tanda terima. Pengaturan ini disimpan agar dapat digunakan oleh fitur lain, misalnya pengiriman notifikasi dan pembuatan tanda terima arsip digital.

[Sisipkan Gambar 4.7 Halaman Pengaturan Sistem]

Pada Gambar 4.7 ditampilkan halaman pengaturan sistem. Admin dapat mengubah konfigurasi yang dibutuhkan tanpa harus melakukan perubahan langsung pada kode program.

#### d. Implementasi Log Aktivitas

Menu log aktivitas digunakan untuk menampilkan riwayat aktivitas pengguna di dalam sistem. Aktivitas yang dicatat antara lain login dan logout pengguna. Fitur ini membantu admin dalam melakukan pemantauan penggunaan sistem.

[Sisipkan Gambar 4.8 Halaman Log Aktivitas]

Pada Gambar 4.8 ditampilkan halaman log aktivitas. Halaman ini berisi daftar aktivitas pengguna, nama pengguna, keterangan aktivitas, dan waktu aktivitas dilakukan.

### 4.2.5 Implementasi Sistem pada Petugas

Petugas merupakan pengguna yang memiliki hak akses untuk mengelola kegiatan operasional perpustakaan. Menu yang tersedia pada petugas meliputi dashboard, kelola buku, kelola arsip digital, kelola anggota, usulan buku, voting buku, peminjaman, pengembalian, booking, antrian, denda dan sanksi, laporan, serta pengaturan rules pengembalian.

[Sisipkan Gambar 4.9 Dashboard Petugas]

Pada Gambar 4.9 ditampilkan dashboard petugas. Dashboard ini menampilkan ringkasan jumlah koleksi, peminjaman aktif, peminjaman terlambat, booking pending, denda aktif, peminjaman terbaru, grafik tren peminjaman, dan kategori buku terpopuler.

#### a. Implementasi Kelola Buku dan Kategori

Menu kelola buku digunakan oleh petugas untuk mengelola data koleksi buku. Petugas dapat menambahkan, mengubah, menghapus, mencari, dan mengimpor data buku. Data buku yang dikelola meliputi judul, kategori, pengarang, penerbit, tahun terbit, stok, dan gambar sampul.

[Sisipkan Gambar 4.10 Halaman Kelola Buku]

Pada Gambar 4.10 ditampilkan halaman kelola buku. Halaman ini menampilkan daftar buku beserta informasi kategori, pengarang, penerbit, tahun, stok, dan tombol aksi. Data buku yang disimpan juga terhubung dengan tabel koleksi agar dapat digunakan pada proses peminjaman.

#### b. Implementasi Kelola Anggota

Menu kelola anggota digunakan oleh petugas untuk mengelola data anggota perpustakaan, yaitu mahasiswa dan dosen. Petugas dapat melihat, menambahkan, mengubah, dan menghapus data anggota.

[Sisipkan Gambar 4.11 Halaman Kelola Anggota]

Pada Gambar 4.11 ditampilkan halaman kelola anggota. Halaman ini membantu petugas dalam mengelola data identitas anggota yang digunakan pada proses peminjaman, booking, antrian, dan denda.

#### c. Implementasi Peminjaman Buku

Menu peminjaman digunakan oleh petugas untuk mencatat transaksi peminjaman koleksi. Pada fitur ini, petugas memilih anggota, memilih koleksi yang akan dipinjam, menentukan tanggal pinjam, dan menentukan batas waktu pengembalian.

[Sisipkan Gambar 4.12 Halaman Peminjaman Buku]

Pada Gambar 4.12 ditampilkan halaman peminjaman buku. Sistem menyediakan pencarian anggota dan pencarian koleksi agar proses input transaksi lebih cepat. Setelah transaksi berhasil dibuat, stok koleksi akan berkurang secara otomatis.

```php
$createdLoans = DB::transaction(function () use ($validated, $koleksiIds) {
    foreach ($koleksiIds as $koleksiId) {
        $collection = Collection::with('book')
            ->where('koleksi_id', $koleksiId)
            ->lockForUpdate()
            ->firstOrFail();

        if ($collection->stock < 1) {
            throw ValidationException::withMessages([
                'koleksi_ids' => 'Stok koleksi sudah habis.',
            ]);
        }

        Loan::create([
            'user_id' => $validated['user_id'],
            'koleksi_id' => $collection->koleksi_id,
            'tgl_pinjam' => $validated['tgl_pinjam'],
            'bts_waktu' => $validated['bts_waktu'],
            'status' => 'dipinjam',
        ]);

        $collection->syncBackingStock(-1);
    }
});
```

Potongan kode tersebut menunjukkan proses pencatatan peminjaman. Sistem menggunakan transaksi basis data dan penguncian data koleksi agar perubahan stok tetap konsisten ketika terjadi transaksi.

#### d. Implementasi Pengembalian Buku dan Pemeriksaan Kondisi

Menu pengembalian digunakan oleh petugas untuk memproses koleksi yang dikembalikan oleh anggota. Pada proses ini, petugas dapat memeriksa kondisi fisik buku menggunakan checklist pengembalian. Jika buku terlambat dikembalikan atau mengalami kerusakan, sistem dapat mencatat denda atau sanksi.

[Sisipkan Gambar 4.13 Halaman Pengembalian Buku]

Pada Gambar 4.13 ditampilkan halaman pengembalian buku. Petugas dapat melihat daftar peminjaman aktif, memproses pengembalian, mengisi hasil pemeriksaan kondisi buku, dan menyimpan catatan pengembalian.

```php
private function calculateLatePenaltyAmount(PenaltyRule $rule, int $daysLate): float
{
    return match ($rule->calculation_type) {
        'per_hari' => max(1, $daysLate) * (float) $rule->default_amount,
        'flat', 'manual' => (float) $rule->default_amount,
        default => 0,
    };
}
```

Potongan kode tersebut menunjukkan proses perhitungan denda keterlambatan. Sistem dapat menghitung denda berdasarkan aturan per hari, nominal tetap, atau manual sesuai pengaturan yang ditentukan petugas.

#### e. Implementasi Booking Buku

Menu booking digunakan oleh petugas untuk mengelola permintaan pemesanan buku dari anggota. Petugas dapat menyetujui, menolak, atau merealisasikan booking menjadi transaksi peminjaman.

[Sisipkan Gambar 4.14 Halaman Booking Buku]

Pada Gambar 4.14 ditampilkan halaman booking buku. Booking yang disetujui memiliki batas waktu pengambilan. Jika anggota datang ke perpustakaan sebelum batas waktu tersebut, petugas dapat merealisasikan booking menjadi peminjaman.

#### f. Implementasi Antrian Buku

Menu antrian digunakan untuk mengelola daftar anggota yang menunggu koleksi ketika stok buku sedang kosong. Sistem memberikan nomor antrian kepada anggota berdasarkan urutan pendaftaran.

[Sisipkan Gambar 4.15 Halaman Antrian Buku]

Pada Gambar 4.15 ditampilkan halaman antrian buku. Petugas dapat melihat daftar antrian dan menandai antrian yang telah selesai diproses ketika koleksi sudah tersedia.

#### g. Implementasi Denda dan Sanksi

Menu denda dan sanksi digunakan oleh petugas untuk mengelola data denda keterlambatan, kerusakan, atau kehilangan buku. Petugas dapat menambahkan denda, melihat status pembayaran, dan menandai denda sebagai lunas.

[Sisipkan Gambar 4.16 Halaman Denda dan Sanksi]

Pada Gambar 4.16 ditampilkan halaman denda dan sanksi. Halaman ini menampilkan nama anggota, jenis denda, nominal, keterangan, dan status pembayaran.

#### h. Implementasi Kelola Arsip Digital

Menu kelola arsip digital digunakan oleh petugas untuk memverifikasi dokumen yang diunggah oleh mahasiswa. Arsip digital yang dikelola meliputi laporan PKL, proposal tugas akhir, dan laporan tugas akhir. Petugas dapat melihat detail arsip, mengubah data, memverifikasi, menolak, mengonfirmasi penerimaan, mengunduh dokumen, dan mengunduh surat tanda terima.

[Sisipkan Gambar 4.17 Halaman Kelola Arsip Digital]

Pada Gambar 4.17 ditampilkan halaman kelola arsip digital. Arsip yang telah diverifikasi dapat diaktifkan agar dapat diakses melalui katalog arsip digital.

```php
DB::transaction(function () use ($archive) {
    $archive->update([
        'status' => 'diverifikasi',
        'verified_at' => now(),
    ]);
});
```

Potongan kode tersebut menunjukkan proses perubahan status arsip ketika petugas melakukan verifikasi. Status arsip digunakan untuk menentukan apakah dokumen masih menunggu pemeriksaan, telah diverifikasi, aktif, atau ditolak.

#### i. Implementasi Usulan dan Voting Buku

Menu usulan buku digunakan oleh petugas untuk memverifikasi rekomendasi buku yang diajukan oleh anggota. Setelah usulan diverifikasi, petugas dapat membuat sesi voting untuk menentukan prioritas pengadaan buku.

[Sisipkan Gambar 4.18 Halaman Usulan dan Voting Buku]

Pada Gambar 4.18 ditampilkan halaman usulan dan voting buku. Petugas dapat membuat sesi voting, memilih item rekomendasi yang akan dimasukkan ke dalam voting, serta melihat hasil suara dari anggota.

#### j. Implementasi Laporan dan Rekap Data

Menu laporan dan rekap digunakan oleh petugas untuk melihat dan mencetak laporan operasional perpustakaan. Jenis laporan yang tersedia meliputi laporan sirkulasi, laporan koleksi, laporan arsip, dan laporan denda.

[Sisipkan Gambar 4.19 Halaman Laporan dan Rekap]

Pada Gambar 4.19 ditampilkan halaman laporan dan rekap. Sistem menyediakan fitur filter data, cetak laporan, dan export data ke Excel sehingga petugas dapat menyusun laporan perpustakaan dengan lebih mudah.

### 4.2.6 Implementasi Sistem pada Mahasiswa

Mahasiswa merupakan anggota perpustakaan yang dapat menggunakan layanan perpustakaan secara mandiri melalui sistem. Menu yang tersedia pada mahasiswa meliputi dashboard, katalog buku, katalog arsip mahasiswa, pinjaman, booking, antrian, riwayat, usulan buku, voting buku, upload arsip digital, dan profil.

[Sisipkan Gambar 4.20 Dashboard Mahasiswa]

Pada Gambar 4.20 ditampilkan dashboard mahasiswa. Dashboard ini menampilkan jumlah pinjaman aktif, jumlah booking, total denda belum dibayar, jumlah pinjaman terlambat, jumlah arsip yang telah diunggah, serta daftar pinjaman aktif.

#### a. Implementasi Katalog Buku

Menu katalog buku digunakan oleh mahasiswa untuk melihat daftar buku yang tersedia di perpustakaan. Mahasiswa dapat melakukan pencarian buku dan melihat informasi buku seperti judul, kategori, pengarang, penerbit, tahun, dan stok.

[Sisipkan Gambar 4.21 Halaman Katalog Buku Mahasiswa]

Pada Gambar 4.21 ditampilkan halaman katalog buku mahasiswa. Dari halaman ini, mahasiswa dapat melakukan booking jika stok buku tersedia atau masuk ke antrian jika stok buku sedang kosong.

#### b. Implementasi Rak Pinjam

Menu rak pinjam digunakan mahasiswa untuk memantau layanan peminjaman. Menu ini terdiri dari pinjaman aktif, booking, antrian, dan riwayat peminjaman.

[Sisipkan Gambar 4.22 Halaman Rak Pinjam Mahasiswa]

Pada Gambar 4.22 ditampilkan halaman rak pinjam mahasiswa. Mahasiswa dapat melihat koleksi yang sedang dipinjam, status booking, posisi antrian, dan riwayat peminjaman yang telah selesai.

#### c. Implementasi Upload Arsip Digital

Menu upload arsip digital digunakan oleh mahasiswa untuk mengunggah dokumen akademik ke sistem. Jenis dokumen yang dapat diunggah meliputi laporan PKL, proposal tugas akhir, dan laporan tugas akhir. Data yang diunggah akan diperiksa oleh petugas sebelum dapat diakses pada katalog arsip digital.

[Sisipkan Gambar 4.23 Halaman Upload Arsip Digital Mahasiswa]

Pada Gambar 4.23 ditampilkan halaman upload arsip digital. Mahasiswa mengisi data judul, tahun, pembimbing, penguji, dan file dokumen. Setelah data disimpan, status dokumen akan menjadi pending sampai diverifikasi oleh petugas.

#### d. Implementasi Usulan dan Voting Buku

Menu usulan buku digunakan oleh mahasiswa untuk mengajukan rekomendasi buku baru kepada perpustakaan. Menu voting buku digunakan untuk memberikan suara terhadap buku yang menjadi kandidat pengadaan.

[Sisipkan Gambar 4.24 Halaman Usulan dan Voting Buku Mahasiswa]

Pada Gambar 4.24 ditampilkan halaman usulan dan voting buku mahasiswa. Fitur ini memungkinkan mahasiswa ikut berpartisipasi dalam proses pengembangan koleksi perpustakaan.

### 4.2.7 Implementasi Sistem pada Dosen

Dosen merupakan anggota perpustakaan yang memiliki hak akses hampir sama dengan mahasiswa, tetapi tidak memiliki menu upload arsip digital. Menu yang tersedia pada dosen meliputi dashboard, katalog buku, katalog arsip mahasiswa, pinjaman, booking, antrian, riwayat, usulan buku baru, voting buku, dan profil.

[Sisipkan Gambar 4.25 Dashboard Dosen]

Pada Gambar 4.25 ditampilkan dashboard dosen. Dashboard dosen menampilkan jumlah pinjaman aktif, total booking, total denda belum dibayar, jumlah pinjaman terlambat, jumlah rekomendasi buku, dan daftar pinjaman aktif.

#### a. Implementasi Katalog Buku dan Arsip Mahasiswa

Menu katalog buku digunakan oleh dosen untuk melihat koleksi buku yang tersedia. Selain itu, dosen juga dapat mengakses katalog arsip mahasiswa untuk membaca dokumen akademik yang telah aktif, seperti laporan PKL, proposal tugas akhir, dan laporan tugas akhir.

[Sisipkan Gambar 4.26 Halaman Katalog Dosen]

Pada Gambar 4.26 ditampilkan halaman katalog pada akun dosen. Dosen dapat mencari koleksi, melihat detail buku, melakukan booking, masuk antrian, serta membaca arsip digital yang tersedia.

#### b. Implementasi Rak Pinjam Dosen

Menu rak pinjam pada dosen digunakan untuk melihat pinjaman aktif, booking, antrian, dan riwayat peminjaman. Fitur ini membantu dosen memantau status layanan perpustakaan yang sedang digunakan.

[Sisipkan Gambar 4.27 Halaman Rak Pinjam Dosen]

Pada Gambar 4.27 ditampilkan halaman rak pinjam dosen. Informasi yang ditampilkan meliputi judul koleksi, tanggal pinjam, batas waktu pengembalian, status, dan riwayat peminjaman.

#### c. Implementasi Usulan dan Voting Buku Dosen

Dosen dapat mengusulkan buku baru yang dianggap relevan dengan kebutuhan pembelajaran atau referensi akademik. Selain itu, dosen juga dapat mengikuti voting buku untuk menentukan prioritas pengadaan koleksi.

[Sisipkan Gambar 4.28 Halaman Usulan dan Voting Buku Dosen]

Pada Gambar 4.28 ditampilkan halaman usulan dan voting buku pada akun dosen. Fitur ini digunakan sebagai media partisipasi dosen dalam pengembangan koleksi perpustakaan.

### 4.2.8 Implementasi Pembatasan Hak Akses

Pembatasan hak akses diterapkan agar setiap pengguna hanya dapat mengakses menu yang sesuai dengan perannya. Sistem menggunakan middleware role untuk memeriksa role pengguna sebelum mengizinkan akses ke halaman tertentu.

```php
public function handle(Request $request, Closure $next, string ...$roles): Response
{
    if (!$request->user()) {
        return redirect()->route('login');
    }

    $userRole = $request->user()->role->role_name ?? '';

    if (!in_array($userRole, $roles)) {
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }

    return $next($request);
}
```

Potongan kode tersebut menunjukkan proses pemeriksaan role pengguna. Jika role pengguna tidak sesuai dengan role yang diizinkan, sistem akan menolak akses dan menampilkan pesan bahwa pengguna tidak memiliki hak akses ke halaman tersebut.

### 4.2.9 Implementasi Notifikasi dan Log Aktivitas

Sistem menyediakan fitur notifikasi dan log aktivitas untuk mendukung pengelolaan layanan perpustakaan. Notifikasi digunakan untuk memberikan informasi kepada pengguna, sedangkan log aktivitas digunakan untuk mencatat aktivitas penting yang dilakukan pengguna di dalam sistem.

[Sisipkan Gambar 4.29 Halaman Pengaturan Notifikasi]

Pada Gambar 4.29 ditampilkan halaman pengaturan notifikasi. Admin dapat mengatur konfigurasi notifikasi WhatsApp dan email. Pengaturan ini digunakan oleh sistem untuk mengirim pesan terkait layanan perpustakaan, seperti informasi peminjaman, pengingat pengembalian, dan informasi antrian.

[Sisipkan Gambar 4.30 Halaman Log Aktivitas]

Pada Gambar 4.30 ditampilkan halaman log aktivitas. Aktivitas seperti login dan logout dicatat oleh sistem sehingga admin dapat melihat riwayat penggunaan aplikasi.

### 4.2.10 Ringkasan Implementasi Fitur Sistem

Berdasarkan hasil implementasi, Sistem Informasi Perpustakaan telah menyediakan fitur utama sesuai kebutuhan pengguna. Ringkasan implementasi fitur ditunjukkan pada Tabel 4.1.

**Tabel 4.1 Ringkasan Implementasi Fitur Sistem**

| No | Pengguna | Fitur | Keterangan |
| :---: | :--- | :--- | :--- |
| 1 | Publik | Beranda sistem | Menampilkan informasi umum perpustakaan, statistik, dan buku terbaru. |
| 2 | Mahasiswa/Dosen | Registrasi | Membuat akun anggota perpustakaan secara mandiri. |
| 3 | Semua pengguna | Login | Mengautentikasi pengguna dan mengarahkan ke dashboard sesuai role. |
| 4 | Admin | Kelola user | Mengelola data akun admin, petugas, mahasiswa, dan dosen. |
| 5 | Admin | Kelola prodi dan jurusan | Mengelola data akademik yang digunakan pada profil anggota. |
| 6 | Admin | Pengaturan sistem | Mengelola konfigurasi WhatsApp, email, dan template tanda terima. |
| 7 | Admin | Log aktivitas | Melihat riwayat aktivitas pengguna di sistem. |
| 8 | Petugas | Kelola buku dan kategori | Mengelola data koleksi buku dan kategori buku. |
| 9 | Petugas | Kelola anggota | Mengelola data mahasiswa dan dosen sebagai anggota perpustakaan. |
| 10 | Petugas | Peminjaman | Mencatat transaksi peminjaman koleksi. |
| 11 | Petugas | Pengembalian | Memproses pengembalian dan pemeriksaan kondisi koleksi. |
| 12 | Petugas | Denda dan sanksi | Mengelola denda keterlambatan, kerusakan, dan kehilangan. |
| 13 | Petugas | Booking dan antrian | Mengelola pemesanan buku dan daftar tunggu koleksi. |
| 14 | Petugas | Arsip digital | Memverifikasi dan mengelola arsip laporan mahasiswa. |
| 15 | Petugas | Laporan | Menampilkan, mencetak, dan mengekspor laporan perpustakaan. |
| 16 | Mahasiswa | Upload arsip digital | Mengunggah laporan PKL, proposal TA, dan laporan tugas akhir. |
| 17 | Mahasiswa/Dosen | Katalog buku | Melihat dan mencari koleksi buku perpustakaan. |
| 18 | Mahasiswa/Dosen | Rak pinjam | Melihat pinjaman aktif, booking, antrian, dan riwayat peminjaman. |
| 19 | Mahasiswa/Dosen | Katalog arsip | Melihat dan membaca arsip digital yang telah aktif. |
| 20 | Mahasiswa/Dosen | Usulan dan voting buku | Mengusulkan buku baru dan memberikan suara pada sesi voting. |

Ringkasan pada Tabel 4.1 menunjukkan bahwa sistem telah diimplementasikan sesuai dengan pembagian hak akses pengguna. Setiap fitur dikembangkan berdasarkan kebutuhan role masing-masing, sehingga penggunaan sistem menjadi lebih terarah dan sesuai dengan proses bisnis perpustakaan.
