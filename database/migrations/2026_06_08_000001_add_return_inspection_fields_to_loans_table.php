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
        Schema::table('loans', function (Blueprint $table) {
            $table->enum('return_condition_status', ['baik', 'bermasalah'])
                ->nullable()
                ->after('status');
            $table->json('return_condition_checks')
                ->nullable()
                ->after('return_condition_status');
            $table->text('return_condition_notes')
                ->nullable()
                ->after('return_condition_checks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn([
                'return_condition_status',
                'return_condition_checks',
                'return_condition_notes',
            ]);
        });
    }
};
