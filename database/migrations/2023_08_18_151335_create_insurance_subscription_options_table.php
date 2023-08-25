<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('insurance_subscription_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('duration');
            $table->decimal('sale_percentage', 3);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_subscription_options');
    }
};
