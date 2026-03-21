<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_experiences', function (Blueprint $table) {
            $table->id();

            /* RELATION */
            $table->unsignedBigInteger('student_id');

            /* EXPERIENCE DETAILS */
            $table->string('company_name')->nullable();
            $table->string('job_profile')->nullable();
            $table->string('job_duration')->nullable(); // From - To
            $table->string('job_state')->nullable();
            $table->string('job_district')->nullable();
            $table->string('salary_range')->nullable();
            $table->text('job_summary')->nullable();

            $table->timestamps();

            $table->foreign('student_id')
                  ->references('id')
                  ->on('students')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_experiences');
    }
};
