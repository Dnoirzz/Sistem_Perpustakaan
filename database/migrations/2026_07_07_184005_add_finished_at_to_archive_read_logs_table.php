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
        Schema::table('archive_read_logs', function (Blueprint $table) {
            $table->timestamp('finished_at')->nullable()->after('archive_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('archive_read_logs', function (Blueprint $table) {
            $table->dropColumn('finished_at');
        });
    }
};
