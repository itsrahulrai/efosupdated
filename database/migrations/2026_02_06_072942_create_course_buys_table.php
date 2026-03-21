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
    Schema::create('course_buys', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->foreignId('learning_course_id')
            ->constrained('learning_courses')
            ->cascadeOnDelete();

        $table->enum('type', ['free', 'paid'])->default('free');

        $table->decimal('amount', 10, 2)->default(0);
        $table->decimal('discount_amount', 10, 2)->default(0);
        $table->string('coupon_code')->nullable();

        $table->enum('payment_status', [
            'pending',
            'success',
            'failed',
            'refunded'
        ])->default('success');

        $table->string('transaction_id')->nullable()->index();
        $table->string('payment_gateway')->nullable();

        $table->boolean('is_active')->default(true);
        $table->boolean('is_refunded')->default(false);

        $table->timestamp('purchased_at')->nullable();
        $table->timestamp('refunded_at')->nullable();
        $table->timestamp('expires_at')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_buys');
    }
};
