<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan status transaksi khusus untuk buku yang diproses hilang.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE loans MODIFY COLUMN status ENUM('dipinjam', 'dikembalikan', 'terlambat', 'hilang') NOT NULL DEFAULT 'dipinjam'");
            return;
        }

        if (DB::getDriverName() === 'sqlite') {
            $this->rebuildSqliteLoansTable(['dipinjam', 'dikembalikan', 'terlambat', 'hilang']);
        }
    }

    /**
     * Kembalikan enum ke daftar status sebelum fitur buku hilang.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::table('loans')->where('status', 'hilang')->update(['status' => 'dikembalikan']);
            DB::statement("ALTER TABLE loans MODIFY COLUMN status ENUM('dipinjam', 'dikembalikan', 'terlambat') NOT NULL DEFAULT 'dipinjam'");
            return;
        }

        if (DB::getDriverName() === 'sqlite') {
            DB::table('loans')->where('status', 'hilang')->update(['status' => 'dikembalikan']);
            $this->rebuildSqliteLoansTable(['dipinjam', 'dikembalikan', 'terlambat']);
        }
    }

    /**
     * SQLite tidak mendukung ALTER ENUM; tabel perlu dibuat ulang agar
     * constraint status ikut memuat nilai baru.
     */
    private function rebuildSqliteLoansTable(array $statuses): void
    {
        $statusList = implode(', ', array_map(
            fn (string $status) => "'" . str_replace("'", "''", $status) . "'",
            $statuses
        ));

        Schema::disableForeignKeyConstraints();

        Schema::create('loans_new', function ($table) use ($statusList) {
            $table->id('loan_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->foreignId('koleksi_id')->constrained('collections', 'koleksi_id')->onDelete('cascade');
            $table->date('tgl_pinjam');
            $table->date('bts_waktu');
            $table->date('tgl_kembali')->nullable();
            $table->enum('status', explode(', ', str_replace("'", '', $statusList)))->default('dipinjam');
            $table->enum('return_condition_status', ['baik', 'bermasalah'])->nullable();
            $table->json('return_condition_checks')->nullable();
            $table->text('return_condition_notes')->nullable();
            $table->timestamps();
        });

        DB::statement('INSERT INTO loans_new (loan_id, user_id, koleksi_id, tgl_pinjam, bts_waktu, tgl_kembali, status, return_condition_status, return_condition_checks, return_condition_notes, created_at, updated_at) SELECT loan_id, user_id, koleksi_id, tgl_pinjam, bts_waktu, tgl_kembali, status, return_condition_status, return_condition_checks, return_condition_notes, created_at, updated_at FROM loans');
        Schema::drop('loans');
        Schema::rename('loans_new', 'loans');

        Schema::enableForeignKeyConstraints();
    }
};
