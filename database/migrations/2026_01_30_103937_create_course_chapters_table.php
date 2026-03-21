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
        Schema::create('course_chapters', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('course_id')->constrained('learning_courses')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->boolean('is_locked')->default(false)->comment('Admin can lock/unlock chapter 0 (unlocked) / 1 (locked)');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_chapters');
    }
};
