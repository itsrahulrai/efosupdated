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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('student_id');

            // Document data
            $table->string('title');          // Aadhaar, Resume, Certificate
            $table->string('file_path');      // uploads/documents/xxx.pdf
            $table->string('file_type')->nullable(); // pdf, jpg, png
            $table->integer('file_size')->nullable(); // KB

            // Meta
            $table->boolean('is_verified')->default(false);
            // $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('student_id')
                  ->references('id')->on('students')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
