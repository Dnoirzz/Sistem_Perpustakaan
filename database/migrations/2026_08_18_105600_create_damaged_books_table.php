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
        Schema::create('damaged_books', function (Blueprint $table) {
            $table->id('damaged_book_id');
            $table->foreignId('loan_id')->nullable()->constrained('loans', 'loan_id')->nullOnDelete();
            $table->foreignId('koleksi_id')->constrained('collections', 'koleksi_id')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users', 'user_id')->nullOnDelete();
            $table->foreignId('reported_by')->constrained('users', 'user_id')->cascadeOnDelete();
            $table->dateTime('reported_at');
            $table->text('condition_notes')->nullable();
            $table->enum('status', [
                'menunggu_penggantian',
                'selesai_diganti_sama',
                'selesai_diganti_koleksi_baru',
                'diafkir_perbaikan'
            ])->default('menunggu_penggantian');
            $table->foreignId('replacement_koleksi_id')->nullable()->constrained('collections', 'koleksi_id')->nullOnDelete();
            $table->text('replacement_notes')->nullable();
            $table->dateTime('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damaged_books');
    }
};
