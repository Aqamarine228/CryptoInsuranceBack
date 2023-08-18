<?php

use App\Enums\ReferralRequestStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('referral_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->timestamp('approved_at')->nullable();
            $table->enum('status', ReferralRequestStatus::values())->default(ReferralRequestStatus::PENDING->value);
            $table->string('telegram_account');
            $table->text('rejection_reason_en')->nullable();
            $table->text('rejection_reason_ru')->nullable();
            $table->string('document_photo');
            $table->string('address');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referral_requests');
    }
};
