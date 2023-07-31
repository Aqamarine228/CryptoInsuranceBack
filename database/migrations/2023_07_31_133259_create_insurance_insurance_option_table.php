<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('insurance_insurance_option', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_id')->constrained();
            $table->foreignId('insurance_option_id')->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_insurance_option');
    }
};
