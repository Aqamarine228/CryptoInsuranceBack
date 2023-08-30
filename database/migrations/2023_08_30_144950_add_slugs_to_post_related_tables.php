<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable();
        });
        Schema::table('post_categories', function (Blueprint $table) {
            $table->string('slug')->unique();
        });
        Schema::table('post_tags', function (Blueprint $table) {
            $table->string('slug')->unique();
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
        Schema::table('post_categories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
        Schema::table('post_tags', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
