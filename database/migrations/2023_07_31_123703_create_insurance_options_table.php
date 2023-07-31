<?php

use App\Enums\Currencies;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('insurance_options', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ru');
            $table->string('slug');
            $table->decimal('price');
            $table->enum('currency', Currencies::values())->default(Currencies::USDT->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_options');
    }
};
