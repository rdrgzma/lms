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
        Schema::table('courses_and_videos', function (Blueprint $table) {
            Schema::table('courses', function (Blueprint $table) {
                $table->boolean('is_published')->default(false);
            });

            Schema::table('videos', function (Blueprint $table) {
                $table->boolean('is_published')->default(false);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses_and_videos', function (Blueprint $table) {
            Schema::table('courses', function (Blueprint $table) {
                $table->dropColumn('is_published');
            });

            Schema::table('videos', function (Blueprint $table) {
                $table->dropColumn('is_published');
            });
        });
    }
};
