<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penalties', function (Blueprint $table) {
            $table->timestamp('payment_received_at')
                ->nullable()
                ->after('status');
            $table->timestamp('replacement_received_at')
                ->nullable()
                ->after('payment_received_at');
        });

        // Sebelum kolom ini tersedia, proses buku hilang dengan metode
        // ganti_buku/kombinasi langsung menambah stok saat sanksi dibuat.
        // Tandai data lama sebagai sudah diterima agar konfirmasi baru tidak
        // menambah stok untuk kedua kalinya.
        DB::table('penalties')
            ->where('type', 'kehilangan')
            ->whereIn('penalti_type', ['ganti_buku', 'kombinasi'])
            ->update(['replacement_received_at' => DB::raw('updated_at')]);
    }

    public function down(): void
    {
        Schema::table('penalties', function (Blueprint $table) {
            $table->dropColumn([
                'payment_received_at',
                'replacement_received_at',
            ]);
        });
    }
};
