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
        // Tabel Prodi - menyimpan data program studi
        Schema::create('prodi', function (Blueprint $table) {
            $table->id('prodi_id');
            $table->string('nama_prodi');
            $table->timestamps();
        });

        // Tabel Mahasiswas - menyimpan data mahasiswa
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id('mhs_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->foreignId('prodi_id')->constrained('prodi', 'prodi_id')->onDelete('cascade');
            $table->string('nim')->unique();
            $table->string('semester')->nullable();
            $table->timestamps();
        });

        // Tabel Dosens - menyimpan data dosen
        Schema::create('dosens', function (Blueprint $table) {
            $table->id('dosen_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->string('nip')->unique();
            $table->foreignId('prodi_id')->constrained('prodi', 'prodi_id')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabel Petugas - menyimpan data petugas perpustakaan
        Schema::create('petugas', function (Blueprint $table) {
            $table->id('staff_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->string('nip')->unique();
            $table->string('jabatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petugas');
        Schema::dropIfExists('dosens');
        Schema::dropIfExists('mahasiswas');
        Schema::dropIfExists('prodi');
    }
};
