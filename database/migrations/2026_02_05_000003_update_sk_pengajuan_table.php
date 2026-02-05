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
        Schema::table('sk_pengajuan', function (Blueprint $table) {
            // Drop old columns if they exist
            if (Schema::hasColumn('sk_pengajuan', 'submitted_by')) {
                $table->dropForeign(['submitted_by']);
                $table->dropColumn('submitted_by');
            }

            if (Schema::hasColumn('sk_pengajuan', 'alamat')) {
                $table->dropColumn('alamat');
            }

            if (Schema::hasColumn('sk_pengajuan', 'pondok')) {
                $table->dropColumn('pondok');
            }

            if (Schema::hasColumn('sk_pengajuan', 'file_pendukung')) {
                $table->dropColumn('file_pendukung');
            }

            // Add new columns if they don't exist
            if (!Schema::hasColumn('sk_pengajuan', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('nama');
            }

            if (!Schema::hasColumn('sk_pengajuan', 'dokumen')) {
                $table->string('dokumen')->nullable()->after('deskripsi');
            }

            // Update foreign keys for cascading deletes
            if (Schema::hasColumn('sk_pengajuan', 'korwil_id')) {
                // Drop and recreate with cascade
                $table->dropForeign(['korwil_id']);
                $table->foreign('korwil_id')->references('id')->on('korwils')->onDelete('cascade');
            }

            if (Schema::hasColumn('sk_pengajuan', 'rayon_id')) {
                // Drop and recreate with cascade
                $table->dropForeign(['rayon_id']);
                $table->foreign('rayon_id')->references('id')->on('rayons')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sk_pengajuan', function (Blueprint $table) {
            // Recreate old columns
            if (!Schema::hasColumn('sk_pengajuan', 'submitted_by')) {
                $table->foreignId('submitted_by')->constrained('users')->onDelete('cascade')->after('korwil_id');
            }

            if (!Schema::hasColumn('sk_pengajuan', 'alamat')) {
                $table->text('alamat')->nullable()->after('nama');
            }

            if (!Schema::hasColumn('sk_pengajuan', 'pondok')) {
                $table->string('pondok')->nullable()->after('alamat');
            }

            if (!Schema::hasColumn('sk_pengajuan', 'file_pendukung')) {
                $table->string('file_pendukung')->nullable()->after('korwil_id');
            }

            // Drop new columns
            if (Schema::hasColumn('sk_pengajuan', 'deskripsi')) {
                $table->dropColumn('deskripsi');
            }

            if (Schema::hasColumn('sk_pengajuan', 'dokumen')) {
                $table->dropColumn('dokumen');
            }
        });
    }
};
