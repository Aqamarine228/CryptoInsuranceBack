<?php

use App\Models\WidgetVariable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('widget_variables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('value');
        });

        Model::unguarded(function () {
            WidgetVariable::createRequired();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('widget_variables');
    }
};
