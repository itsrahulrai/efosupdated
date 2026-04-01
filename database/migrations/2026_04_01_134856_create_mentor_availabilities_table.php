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
        Schema::create('mentor_availabilities', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('mentor_id')
                ->constrained('mentor_profiles')
                ->onDelete('cascade');

            // day of week
            $table->enum('day', [
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday',
                'sunday',
            ]);
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('slot_gap')->default(10);           
            $table->string('timezone')->default('Asia/Kolkata');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentor_availabilities');
    }
};
