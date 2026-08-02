<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // The base transactions migration already includes `dibatalkan`.
        // Only MySQL needs this ALTER for databases created before that
        // status was added; SQLite cannot alter an enum column this way.
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE antrian MODIFY COLUMN status ENUM('menunggu', 'tersedia', 'selesai', 'dibatalkan') NOT NULL DEFAULT 'menunggu'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE antrian MODIFY COLUMN status ENUM('menunggu', 'tersedia', 'selesai') NOT NULL DEFAULT 'menunggu'");
        }
    }
};
