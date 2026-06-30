<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['laporan_pkl', 'proposal_ta', 'laporan_tugas_akhir'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->enum('status', ['pending', 'diverifikasi', 'aktif', 'ditolak'])
                    ->default('pending')
                    ->after('file_word');
                $table->text('catatan_petugas')->nullable()->after('status');
                $table->string('preview_pdf')->nullable()->after('catatan_petugas');
                $table->string('surat_tanda_terima_pdf')->nullable()->after('preview_pdf');
                $table->string('nomor_surat')->nullable()->after('surat_tanda_terima_pdf');
                $table->timestamp('verified_at')->nullable()->after('nomor_surat');
                $table->timestamp('received_at')->nullable()->after('verified_at');
            });
        }
    }

    public function down(): void
    {
        foreach (['laporan_pkl', 'proposal_ta', 'laporan_tugas_akhir'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn([
                    'status',
                    'catatan_petugas',
                    'preview_pdf',
                    'surat_tanda_terima_pdf',
                    'nomor_surat',
                    'verified_at',
                    'received_at',
                ]);
            });
        }
    }
};
