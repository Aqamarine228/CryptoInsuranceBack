<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('insurance_coverage_options', function (Blueprint $table) {
//            $table->decimal('price_percentage', 8, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('insurance_coverage_options', function (Blueprint $table) {
            $table->decimal('price_percentage', 5, 2)->change();
        });
    }
};
