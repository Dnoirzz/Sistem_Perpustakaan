<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel Loans - transaksi peminjaman
        Schema::create('loans', function (Blueprint $table) {
            $table->id('loan_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->foreignId('koleksi_id')->constrained('collections', 'koleksi_id')->onDelete('cascade');
            $table->date('tgl_pinjam');
            $table->date('bts_waktu');
            $table->date('tgl_kembali')->nullable();
            $table->enum('status', ['dipinjam', 'dikembalikan', 'terlambat'])->default('dipinjam');
            $table->timestamps();
        });

        // Tabel Bookings - reservasi buku online
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('booking_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->foreignId('koleksi_id')->constrained('collections', 'koleksi_id')->onDelete('cascade');
            $table->date('tgl_booking');
            $table->enum('status', ['pending', 'disetujui', 'dibatalkan', 'selesai'])->default('pending');
            $table->timestamps();
        });

        // Tabel Antrian - antrian peminjaman buku
        Schema::create('antrian', function (Blueprint $table) {
            $table->id('antrian_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->foreignId('koleksi_id')->constrained('collections', 'koleksi_id')->onDelete('cascade');
            $table->integer('no_antrian');
            $table->enum('status', ['menunggu', 'tersedia', 'selesai'])->default('menunggu');
            $table->timestamps();
        });

        // Tabel Penalties - sanksi/denda
        Schema::create('penalties', function (Blueprint $table) {
            $table->id('penalti_id');
            $table->foreignId('loan_id')->constrained('loans', 'loan_id')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->enum('type', ['keterlambatan', 'kehilangan', 'kerusakan']);
            $table->string('penalti_type')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->text('description')->nullable();
            $table->enum('status', ['belum_dibayar', 'lunas'])->default('belum_dibayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penalties');
        Schema::dropIfExists('antrian');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('loans');
    }
};
