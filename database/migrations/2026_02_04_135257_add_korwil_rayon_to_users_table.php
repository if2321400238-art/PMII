<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('korwil_id')->nullable()->after('role_id')->constrained('korwils')->nullOnDelete();
            $table->foreignId('rayon_id')->nullable()->after('korwil_id')->constrained('rayons')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['korwil_id']);
            $table->dropForeign(['rayon_id']);
            $table->dropColumn(['korwil_id', 'rayon_id']);
        });
    }
};
