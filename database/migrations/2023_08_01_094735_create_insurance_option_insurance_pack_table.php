<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('insurance_option_insurance_pack', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_option_id')->constrained();
            $table->foreignId('insurance_pack_id')->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_option_insurance_pack');
    }
};
