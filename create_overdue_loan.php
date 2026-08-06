<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Mahasiswa;
use App\Models\Loan;
use App\Models\Penalty;
use App\Models\PenaltyRule;

$nim = '3202316109';
$mahasiswa = Mahasiswa::where('nim', $nim)->with('user')->first();

if (!$mahasiswa) {
    echo "ERROR: Mahasiswa dengan NIM {$nim} tidak ditemukan!\n";
    exit(1);
}

$user = $mahasiswa->user;

// Cari loan yang tadi baru kita buat
$loan = Loan::where('user_id', $user->user_id)->where('status', 'terlambat')->latest()->first();

if (!$loan) {
    echo "ERROR: Loan terlambat tidak ditemukan!\n";
    exit(1);
}

// Ambil tarif denda per hari (code = keterlambatan)
$rule = PenaltyRule::where('code', 'keterlambatan')->first();
$dendaPerHari = $rule ? (float) $rule->default_amount : 1000.0;
$totalDenda = 7 * $dendaPerHari;

// Buat record denda jika belum ada
$penalty = Penalty::firstOrCreate(
    ['loan_id' => $loan->loan_id],
    [
        'user_id' => $user->user_id,
        'type' => 'keterlambatan',
        'penalti_type' => 'uang_tunai',
        'amount' => $totalDenda,
        'description' => "Denda keterlambatan 7 hari (Rp " . number_format($dendaPerHari, 0, ',', '.') . "/hari)",
        'status' => 'belum_dibayar',
    ]
);

echo "SUKSES BUAT PENALTY!\n";
echo "Loan ID      : {$loan->loan_id}\n";
echo "Peminjam     : {$user->name} (NIM: {$nim})\n";
echo "Koleksi ID   : {$loan->koleksi_id} ({$loan->collection?->display_title})\n";
echo "Tgl Pinjam   : " . $loan->tgl_pinjam->format('d M Y') . "\n";
echo "Jatuh Tempo  : " . $loan->bts_waktu->format('d M Y') . " (Terlambat 7 Hari)\n";
echo "Penalty ID   : {$penalty->penalti_id}\n";
echo "Total Denda  : Rp " . number_format($penalty->amount, 0, ',', '.') . " (Status: {$penalty->status})\n";
