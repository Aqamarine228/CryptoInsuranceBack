<?php

use App\Enums\Currency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referral_incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('referral_id')->constrained('users');
            $table->morphs('payable');
            $table->decimal('amount');
            $table->enum('currency', Currency::values());
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referral_incomes');
    }
};
