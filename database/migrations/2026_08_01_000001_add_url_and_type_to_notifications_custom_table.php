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
        Schema::table('notifications_custom', function (Blueprint $table) {
            $table->string('url')->nullable()->after('message');
            $table->string('type')->default('info')->after('url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications_custom', function (Blueprint $table) {
            $table->dropColumn(['url', 'type']);
        });
    }
};
