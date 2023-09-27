<?php

use App\Models\MediaFolder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('media_folders', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('media_folder_id')->nullable()->constrained();
            $table->timestamps();
        });

        MediaFolder::firstOrCreate([
            'id' => 1,
            'name' => 'images',
        ]);
        MediaFolder::firstOrCreate([
            'id' => 2,
            'name' => 'advertising',
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('media_folders');
    }
};
