<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('insurance_invoice_insurance_option', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_invoice_id')->constrained()->cascadeOnDelete();
            $table->foreignId('insurance_option_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_invoice_insurance_option');
    }
};
