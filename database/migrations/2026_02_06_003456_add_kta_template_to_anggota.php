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
        Schema::table('anggota', function (Blueprint $table) {
            $table->foreignId('kta_template_id')->nullable()->after('rayon_id')->constrained('k_t_a_templates')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->dropForeign(['kta_template_id']);
            $table->dropColumn('kta_template_id');
        });
    }
};
