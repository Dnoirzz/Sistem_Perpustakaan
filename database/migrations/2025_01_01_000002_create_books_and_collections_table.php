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
        // Tabel Categories - menyimpan kategori buku
        Schema::create('categories', function (Blueprint $table) {
            $table->id('kategori_id');
            $table->string('kategori_name');
            $table->timestamps();
        });

        // Tabel Books - menyimpan data buku
        Schema::create('books', function (Blueprint $table) {
            $table->id('buku_id');
            $table->foreignId('kategori_id')->constrained('categories', 'kategori_id')->onDelete('cascade');
            $table->string('judul');
            $table->string('author');
            $table->string('publisher')->nullable();
            $table->year('release')->nullable();
            $table->integer('stock')->default(0);
            $table->string('cover_image')->nullable();
            $table->timestamps();
        });

        // Tabel Collections - koleksi perpustakaan (polimorfik: buku, PKL, TA)
        Schema::create('collections', function (Blueprint $table) {
            $table->id('koleksi_id');
            $table->string('item_type'); // 'book', 'laporan_pkl', 'proposal_ta', 'laporan_ta'
            $table->unsignedBigInteger('item_id');
            $table->integer('stock')->default(0);
            $table->timestamps();

            $table->index(['item_type', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
        Schema::dropIfExists('books');
        Schema::dropIfExists('categories');
    }
};
