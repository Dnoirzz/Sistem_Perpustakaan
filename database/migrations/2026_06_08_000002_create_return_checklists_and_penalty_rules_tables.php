<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('return_checklists', function (Blueprint $table) {
            $table->id('return_checklist_id');
            $table->string('item_name');
            $table->string('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('penalty_rules', function (Blueprint $table) {
            $table->id('penalty_rule_id');
            $table->string('code')->unique();
            $table->string('rule_name');
            $table->enum('calculation_type', ['per_hari', 'flat', 'manual'])->default('manual');
            $table->enum('default_settlement_method', ['uang_tunai', 'ganti_buku', 'kombinasi'])->default('uang_tunai');
            $table->decimal('default_amount', 10, 2)->default(0);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('return_checklists')->insert([
            [
                'item_name' => 'Cover buku baik',
                'description' => 'Cover tidak lepas, tidak rusak berat, dan masih layak digunakan.',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name' => 'Halaman lengkap',
                'description' => 'Tidak ada halaman yang hilang, tertukar, atau terlepas.',
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name' => 'Bebas coretan',
                'description' => 'Tidak ada tulisan, stabilo, atau penandaan yang merusak isi buku.',
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name' => 'Tidak sobek',
                'description' => 'Tidak ada sobekan pada cover maupun isi buku.',
                'sort_order' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name' => 'Tidak basah atau lembap',
                'description' => 'Buku tidak terkena air, jamur, atau kerusakan akibat kelembapan.',
                'sort_order' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('penalty_rules')->insert([
            [
                'code' => 'keterlambatan',
                'rule_name' => 'Denda Keterlambatan',
                'calculation_type' => 'per_hari',
                'default_settlement_method' => 'uang_tunai',
                'default_amount' => 1000,
                'description' => 'Nominal ini dikalikan jumlah hari keterlambatan.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'kerusakan',
                'rule_name' => 'Sanksi Kerusakan Buku',
                'calculation_type' => 'manual',
                'default_settlement_method' => 'uang_tunai',
                'default_amount' => 0,
                'description' => 'Gunakan nominal default bila ada, lalu sesuaikan dengan tingkat kerusakan.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'kehilangan',
                'rule_name' => 'Sanksi Kehilangan Buku',
                'calculation_type' => 'manual',
                'default_settlement_method' => 'ganti_buku',
                'default_amount' => 0,
                'description' => 'Bisa diarahkan ke penggantian buku, uang tunai, atau kombinasi sesuai kebijakan.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penalty_rules');
        Schema::dropIfExists('return_checklists');
    }
};
