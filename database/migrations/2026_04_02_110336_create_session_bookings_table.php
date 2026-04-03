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
        Schema::create('session_bookings', function (Blueprint $table)
        {
            $table->id();

            $table->foreignId('mentor_id')
                ->constrained('mentor_profiles')
                ->cascadeOnDelete();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            $table->foreignId('session_price_id')
                ->constrained('mentor_session_prices')
                ->cascadeOnDelete();

            $table->date('session_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('duration_minutes');
            $table->decimal('price', 8, 2);
            $table->decimal('discount_price', 8, 2)->nullable();
            $table->decimal('final_price', 8, 2);
            $table->string('payment_status')->default('pending');
            $table->string('payment_gateway')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('meeting_platform')->default('zoom');
            $table->string('zoom_meeting_id')->nullable();
            $table->text('zoom_join_url')->nullable();
            $table->text('zoom_start_url')->nullable();
            $table->string('zoom_password')->nullable();
            $table->enum('status', ['pending','accepted','rejected','cancelled','completed',])->default('pending');
            $table->timestamps();
            $table->index(['mentor_id', 'session_date']);

            $table->unique([
                'mentor_id',
                'session_date',
                'start_time',
            ]);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_bookings');
    }
};
