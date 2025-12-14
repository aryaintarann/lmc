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
        // Articles
        Schema::table('articles', function (Blueprint $table) {
            $table->json('title')->change();
            $table->json('excerpt')->nullable()->change();
            $table->json('content')->change();
        });

        // Services
        Schema::table('services', function (Blueprint $table) {
            $table->json('title')->change();
            $table->json('description')->change();
        });

        // Doctors
        Schema::table('doctors', function (Blueprint $table) {
            $table->json('specialty')->change();
            $table->json('bio')->nullable()->change();
        });

        // Settings
        Schema::table('settings', function (Blueprint $table) {
            $table->json('value')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert columns to original types (approximate)
        Schema::table('articles', function (Blueprint $table) {
            $table->string('title')->change();
            $table->text('excerpt')->nullable()->change();
            $table->longText('content')->change();
        });

        Schema::table('services', function (Blueprint $table) {
            $table->string('title')->change();
            $table->text('description')->change();
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->string('specialty')->change();
            $table->text('bio')->nullable()->change();
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->text('value')->nullable()->change();
        });
    }
};
