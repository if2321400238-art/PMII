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
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nomor_anggota')->unique();
            $table->text('alamat')->nullable();
            $table->string('pondok')->nullable();
            $table->foreignId('rayon_id')->constrained('rayons')->onDelete('cascade');
            $table->string('foto')->nullable();
            $table->string('kta_path')->nullable();
            $table->timestamps();

            $table->index('nomor_anggota');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};
