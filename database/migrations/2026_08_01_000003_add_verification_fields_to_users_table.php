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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'status_verifikasi')) {
                $table->enum('status_verifikasi', ['pending', 'verified'])->default('verified')->after('telegram_chat_id');
            }
            if (!Schema::hasColumn('users', 'foto_ktm')) {
                $table->string('foto_ktm')->nullable()->after('status_verifikasi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'foto_ktm')) {
                $table->dropColumn('foto_ktm');
            }
            if (Schema::hasColumn('users', 'status_verifikasi')) {
                $table->dropColumn('status_verifikasi');
            }
        });
    }
};
