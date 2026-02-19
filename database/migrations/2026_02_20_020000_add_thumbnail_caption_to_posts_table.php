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
        if (!Schema::hasColumn('posts', 'thumbnail_caption')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->text('thumbnail_caption')->nullable()->after('thumbnail');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('posts', 'thumbnail_caption')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('thumbnail_caption');
            });
        }
    }
};
