<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('insurance_request_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_request_id')->constrained();
            $table->foreignId('insurance_option_field_id')->constrained();
            $table->string('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_request_fields');
    }
};
