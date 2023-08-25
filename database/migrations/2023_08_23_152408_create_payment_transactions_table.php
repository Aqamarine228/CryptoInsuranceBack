<?php

use App\Enums\Cryptocurrency;
use App\Enums\Currency;
use App\Enums\PaymentTransactionStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->morphs('payable');
            $table->decimal('amount');
            $table->enum('currency', array_merge(Currency::values(), Cryptocurrency::values()));
            $table
                ->enum('status', PaymentTransactionStatus::values())
                ->default(PaymentTransactionStatus::UNPAID->value);
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
