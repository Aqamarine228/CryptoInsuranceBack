<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('insurance_coverage_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coverage');
            $table->decimal('price_percentage', 5);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_coverage_options');
    }
};
