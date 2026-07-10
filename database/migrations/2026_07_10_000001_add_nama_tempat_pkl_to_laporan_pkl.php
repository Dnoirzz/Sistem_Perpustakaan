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
        Schema::table('laporan_pkl', function (Blueprint $table) {
            $table->string('nama_tempat_pkl')->nullable()->after('judul_pkl');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_pkl', function (Blueprint $table) {
            $table->dropColumn('nama_tempat_pkl');
        });
    }
};
