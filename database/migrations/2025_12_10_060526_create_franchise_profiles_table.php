<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('franchise_profiles', function (Blueprint $table) {

            $table->id();

            // Link to users table
            $table->unsignedBigInteger('user_id')->unique();

            // Form fields
            $table->string('owner_name');
            $table->string('company_name');
            $table->string('phone', 20)->unique();
            $table->string('email')->unique();
            $table->string('state');
            $table->string('district');
            $table->string('business_experience');
            $table->text('message')->nullable();

            // Admin Control Fields
            $table->enum('status', ['pending','approved','rejected'])->default('pending');
            $table->boolean('is_active')->default(1);
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();

            // Extra Franchise Tracking (Optional but useful)
            $table->string('franchise_code')->nullable()->unique();
            $table->string('location')->nullable();
            $table->string('investment_range')->nullable();

            $table->timestamps();

            // Foreign Keys
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('approved_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('franchise_profiles');
    }

};
