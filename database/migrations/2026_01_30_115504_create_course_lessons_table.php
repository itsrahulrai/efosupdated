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
        Schema::create('course_lessons', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('course_id')->constrained('learning_courses')->cascadeOnDelete();
            $table->foreignId('chapter_id')->constrained('course_chapters')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('type', ['video', 'text', 'quiz'])->default('video');
            $table->enum('video_source', ['youtube', 'vimeo', 'upload'])->nullable();
            $table->string('video_url')->nullable();
            $table->string('pdf_file')->nullable();
            $table->longText('content')->nullable();
            $table->integer('duration_seconds')->default(0);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_free_preview')->default(false);
            $table->boolean('is_mandatory')->default(true);
            $table->boolean('status')->default(true);
            // $table->timestamps();
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_lessons');
    }
};
