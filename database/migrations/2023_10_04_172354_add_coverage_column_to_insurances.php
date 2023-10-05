<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('insurance_packs', function (Blueprint $table) {
            $table->unsignedBigInteger('coverage');
        });

        Schema::table('insurance_invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('coverage');
        });

        Schema::table('insurances', function (Blueprint $table) {
            $table->unsignedBigInteger('coverage');
        });

        Schema::table('insurance_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('coverage');
        });
    }

    public function down(): void
    {
        Schema::table('insurance_packs', function (Blueprint $table) {
            $table->dropColumn('coverage');
        });

        Schema::table('insurance_invoices', function (Blueprint $table) {
            $table->dropColumn('coverage');
        });

        Schema::table('insurances', function (Blueprint $table) {
            $table->dropColumn('coverage');
        });

        Schema::table('insurance_requests', function (Blueprint $table) {
            $table->dropColumn('coverage');
        });
    }
};
