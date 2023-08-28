<?php

use App\Enums\PostMediaType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('posts', static function (Blueprint $table) {
            $table->id();
            $table->string('title_en')->nullable();
            $table->string('title_ru')->nullable();
            $table->text('content_en')->nullable();
            $table->text('content_ru')->nullable();
            $table->string('picture')->nullable();
            $table->string('short_title_en')->nullable();
            $table->string('short_title_ru')->nullable();
            $table->string('short_content_en')->nullable();
            $table->string('short_content_ru')->nullable();
            $table->enum('media_type', collect(PostMediaType::cases())->pluck('value')->toArray())->nullable();
            $table->foreignId('post_category_id')->nullable()->constrained();
            $table->foreignId('author_id')->nullable()->constrained('admins');
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('likes')->default(0);
            $table->boolean('is_trending_now')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
