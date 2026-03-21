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
        Schema::create('learning_courses', function (Blueprint $table)
        {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('language')->nullable();
            $table->string('level')->nullable();
            $table->string('duration')->nullable();
            $table->string('short_description', 500)->nullable();
            $table->text('description')->nullable();
            $table->foreignId('subject_id')
                ->nullable()
                ->constrained('subjects')
                ->nullOnDelete();
            $table->string('demo_video')->nullable();
            $table->string('currency')->default('INR');
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('is_free')->default(false);
            $table->boolean('has_discount')->default(false);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->date('discount_from')->nullable();
            $table->date('discount_to')->nullable();
            $table->string('thumbnail')->nullable();
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_courses');
    }
};
