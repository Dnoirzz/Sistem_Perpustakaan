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
        // Tabel Recommendations - usulan/rekomendasi buku
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id('rekomendasi_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->string('title');
            $table->string('author')->nullable();
            $table->text('reason')->nullable();
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->timestamps();
        });

        // Tabel Votings - kegiatan voting pengadaan buku
        Schema::create('votings', function (Blueprint $table) {
            $table->id('voting_id');
            $table->string('title');
            $table->text('deskripsi')->nullable();
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->foreignId('created_by')->constrained('users', 'user_id')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabel Voting Items - item rekomendasi dalam voting
        Schema::create('voting_items', function (Blueprint $table) {
            $table->id('voting_item_id');
            $table->foreignId('voting_id')->constrained('votings', 'voting_id')->onDelete('cascade');
            $table->foreignId('rekomendasi_id')->constrained('recommendations', 'rekomendasi_id')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabel Votes - hasil voting pengguna
        Schema::create('votes', function (Blueprint $table) {
            $table->id('vote_id');
            $table->foreignId('voting_item_id')->constrained('voting_items', 'voting_item_id')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['voting_item_id', 'user_id']); // 1 user 1 vote per item
        });

        // Tabel Notifications - notifikasi pengguna
        Schema::create('notifications_custom', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        // Tabel Activity Logs - log aktivitas pengguna
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->string('activity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('notifications_custom');
        Schema::dropIfExists('votes');
        Schema::dropIfExists('voting_items');
        Schema::dropIfExists('votings');
        Schema::dropIfExists('recommendations');
    }
};
