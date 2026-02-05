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
        Schema::create('sk_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe', ['korwil', 'rayon'])->default('rayon');
            $table->string('nama'); // Nomor SK
            $table->text('deskripsi')->nullable();
            $table->string('dokumen')->nullable();
            $table->foreignId('rayon_id')->nullable()->constrained('rayons')->onDelete('cascade');
            $table->foreignId('korwil_id')->nullable()->constrained('korwils')->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'revised', 'rejected'])->default('pending');
            $table->text('catatan_revisi')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('approved_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('tipe');
            $table->index('korwil_id');
            $table->index('rayon_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sk_pengajuan');
    }
};
