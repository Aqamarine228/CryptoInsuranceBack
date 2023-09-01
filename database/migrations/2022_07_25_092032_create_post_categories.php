<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('post_categories', static function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->unique();
            $table->string('name_ru')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_categories');
    }
};
