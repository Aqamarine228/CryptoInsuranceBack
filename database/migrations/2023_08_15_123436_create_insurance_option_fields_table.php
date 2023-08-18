<?php

use App\Enums\InsuranceOptionFieldType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('insurance_option_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ru');
            $table->foreignId('insurance_option_id')->constrained();
            $table->enum('type', InsuranceOptionFieldType::values());
            $table->boolean('required')->default(false);
            $table->string('slug');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_option_fields');
    }
};
