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
        // Update posts table - make author_id nullable and add author_type
        Schema::table('posts', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['author_id']);

            // Make author_id nullable
            $table->unsignedBigInteger('author_id')->nullable()->change();

            // Add author_type for polymorphic relation
            $table->string('author_type')->nullable()->after('author_id');
        });

        // Update galleries table - add uploader_type
        Schema::table('galleries', function (Blueprint $table) {
            // Drop foreign key first if exists
            if (Schema::hasColumn('galleries', 'uploaded_by')) {
                $table->dropForeign(['uploaded_by']);
                $table->unsignedBigInteger('uploaded_by')->nullable()->change();
            }

            // Add uploader_type for polymorphic relation
            $table->string('uploader_type')->nullable()->after('uploaded_by');
        });

        // Set default author_type for existing posts
        \DB::table('posts')->whereNotNull('author_id')->update(['author_type' => 'App\\Models\\User']);

        // Set default uploader_type for existing galleries
        \DB::table('galleries')->whereNotNull('uploaded_by')->update(['uploader_type' => 'App\\Models\\User']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('author_type');
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn('uploader_type');
        });
    }
};
