<?php

use App\Enums\Cryptocurrency;
use App\Enums\Currency;
use App\Enums\WithdrawalStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->decimal('crypto_amount', 24, 8);
            $table->decimal('amount');
            $table->string('address');
            $table->enum('status', WithdrawalStatus::values());
            $table->enum('cryptocurrency', Cryptocurrency::values());
            $table->enum('currency', Currency::values());
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawal_requests');
    }
};
