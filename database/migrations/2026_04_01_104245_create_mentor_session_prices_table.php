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
            Schema::create('mentor_session_prices', function (Blueprint $table)
            {
                $table->id();
                $table->foreignId('mentor_id')->constrained('mentor_profiles')->onDelete('cascade');
                $table->integer('duration_minutes'); // 20, 30, 40
                $table->decimal('price', 10, 2);
                $table->decimal('discount_price', 10, 2)->nullable();
                $table->boolean('is_free')->default(false);
                $table->enum('session_type', ['video', 'chat', 'call'])->default('video');
                $table->enum('meeting_platform', ['zoom', 'google_meet', 'teams', 'custom'])->default('zoom');
                $table->boolean('status')->default(1);
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentor_session_prices');
    }
};
