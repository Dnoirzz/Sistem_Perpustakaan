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
        // Tabel Laporan PKL - arsip laporan praktik kerja lapangan
        Schema::create('laporan_pkl', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas', 'mhs_id')->onDelete('cascade');
            $table->string('judul_pkl');
            $table->string('pembimbing')->nullable();
            $table->string('penguji_1')->nullable();
            $table->string('penguji_2')->nullable();
            $table->year('tahun')->nullable();
            $table->string('file_pdf')->nullable();
            $table->string('file_word')->nullable();
            $table->timestamps();
        });

        // Tabel Proposal TA - arsip proposal tugas akhir
        Schema::create('proposal_ta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas', 'mhs_id')->onDelete('cascade');
            $table->string('judul_proposal');
            $table->string('pembimbing')->nullable();
            $table->string('penguji_1')->nullable();
            $table->string('penguji_2')->nullable();
            $table->year('tahun')->nullable();
            $table->string('file_pdf')->nullable();
            $table->string('file_word')->nullable();
            $table->timestamps();
        });

        // Tabel Laporan Tugas Akhir - arsip laporan TA
        Schema::create('laporan_tugas_akhir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas', 'mhs_id')->onDelete('cascade');
            $table->string('judul_tgs_akhir');
            $table->string('pembimbing')->nullable();
            $table->string('penguji_1')->nullable();
            $table->string('penguji_2')->nullable();
            $table->year('tahun')->nullable();
            $table->string('file_pdf')->nullable();
            $table->string('file_word')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_tugas_akhir');
        Schema::dropIfExists('proposal_ta');
        Schema::dropIfExists('laporan_pkl');
    }
};
