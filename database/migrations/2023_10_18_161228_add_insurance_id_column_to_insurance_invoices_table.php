<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('insurance_invoices', function (Blueprint $table) {
            $table->dropColumn('coverage');
            $table->foreignId('insurance_id')->constrained();
        });
    }

    public function down(): void
    {
        Schema::table('insurance_invoices', function (Blueprint $table) {
            $table->dropColumn('insurance_id');
            $table->unsignedBigInteger('coverage');
        });
    }
};
