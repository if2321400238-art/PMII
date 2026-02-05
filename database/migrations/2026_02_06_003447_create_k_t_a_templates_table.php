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
        Schema::create('k_t_a_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image_path'); // Path ke template image
            $table->json('field_positions')->nullable(); // Posisi fields di image (x, y, size, etc)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('k_t_a_templates');
    }
};
