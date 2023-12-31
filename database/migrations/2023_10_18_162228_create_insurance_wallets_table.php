<?php

use App\Enums\Cryptocurrency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('insurance_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_id')->constrained()->cascadeOnDelete();
            $table->string('cryptocurrency');
            $table->string('value');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_wallets');
    }
};
