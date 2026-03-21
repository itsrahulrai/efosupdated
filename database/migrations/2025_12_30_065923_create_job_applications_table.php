<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            $table->foreignId('job_id')
                ->constrained('jobs')
                ->cascadeOnDelete();

            // Snapshot data (important)
            $table->string('job_title');
            $table->string('company_name')->nullable();
            $table->string('district')->nullable();
            $table->string('state')->nullable();

            // Application status
            $table->enum('status', [
                'applied',
                'shortlisted',
                'rejected',
                'selected'
            ])->default('applied');

            $table->timestamp('applied_at')->nullable();

            $table->timestamps();

            // Prevent duplicate apply
            $table->unique(['student_id', 'job_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
