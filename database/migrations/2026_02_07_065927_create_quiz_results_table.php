<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quiz_results', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('quiz_id')->constrained()->cascadeOnDelete();

            $table->json('answers'); // {question_id: option_index}
            $table->integer('total_questions');
            $table->integer('answered_questions');

            $table->integer('score')->default(0);
            $table->boolean('is_passed')->default(false);
            $table->integer('time_taken'); // seconds

            $table->enum('submit_type', ['manual', 'auto'])->default('manual');

            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_results');
    }
};
