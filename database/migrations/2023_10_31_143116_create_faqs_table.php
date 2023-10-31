<?php



use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question_ru')->index();
            $table->string('question_en')->index();
            $table->text('answer_ru');
            $table->text('answer_en');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('faqs');
    }
};
