<?php

use App\Enums\InsuranceRequestStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('insurance_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('insurance_option_id')->constrained();
            $table
                ->enum('status', InsuranceRequestStatus::values())
                ->default(InsuranceRequestStatus::PENDING->value);
            $table->timestamps();
            $table->string('rejection_reason_en')->nullable();
            $table->string('rejection_reason_ru')->nullable();
            $table->timestamp('approved_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_requests');
    }
};
