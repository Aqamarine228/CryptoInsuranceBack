<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('insurances', function (Blueprint $table) {
            $table->unsignedInteger('max_wallets_count')->default(config('insurance.default_wallets_count'));
            $table->string('exchange_name')->nullable();
            $table->string('exchange_id')->nullable();
            $table->boolean('paid')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('insurances', function (Blueprint $table) {
            $table->dropColumn(['max_wallets_count', 'exchange_name', 'exchange_id', 'paid']);
        });
    }
};
