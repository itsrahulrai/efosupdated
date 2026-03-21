<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table)
        {
            $table->id();

            /* CORE */
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('email')->nullable()->unique();
            $table->string('registration_number')->unique();

            /* BASIC */
            $table->string('whatsapp')->nullable();
            $table->string('age_group')->nullable();
            $table->string('gender')->nullable();
            $table->string('present_status')->nullable();
            $table->string('state')->nullable();
            $table->string('district')->nullable();
            $table->string('looking_for')->nullable();

            /* PROFILE */
            $table->text('profile_summary')->nullable();

            /* PERSONAL */
            $table->string('pincode')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('category')->nullable();
            $table->text('address')->nullable();

            /* EDUCATION */
            $table->string('highest_qualification')->nullable();

            // 10th
            $table->string('tenth_board')->nullable();
            $table->string('tenth_year')->nullable();
            $table->string('tenth_marks')->nullable();
            $table->string('tenth_stream')->nullable();

            // 12th
            $table->string('twelfth_board')->nullable();
            $table->string('twelfth_year')->nullable();
            $table->string('twelfth_marks')->nullable();
            $table->string('twelfth_stream')->nullable();

            // Graduation
            $table->string('graduation_university')->nullable();
            $table->string('graduation_year')->nullable();
            $table->string('graduation_marks')->nullable();
            $table->string('graduation_stream')->nullable();
            $table->string('graduation_field')->nullable();

            // PG / PhD
            $table->string('pg_university')->nullable();
            $table->string('pg_year')->nullable();
            $table->string('pg_marks')->nullable();
            $table->string('pg_stream')->nullable();
            $table->string('pg_field')->nullable();

            $table->string('phd_university')->nullable();
            $table->string('phd_year')->nullable();
            $table->string('phd_subject')->nullable();
            $table->string('phd_status')->nullable();

            /* SKILL */
            $table->string('skill_type')->nullable();
            $table->string('skill_trade')->nullable();
            $table->string('skill_year')->nullable();

            /* JOB TYPE ONLY */
            $table->string('experience_type')->nullable(); // Fresher / Experienced

            /* OTHER */
            $table->string('passport')->nullable();
            $table->string('relocation')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('photo')->nullable();

            /* META */
            $table->string('apply_type')->default('general');
            $table->enum('profile_completed', [
                'pending',
                'processing',
                'completed',
                'rejected',
                'on_hold',
            ])->default('pending');

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
