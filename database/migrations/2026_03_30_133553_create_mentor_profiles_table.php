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
            Schema::create('mentor_profiles', function (Blueprint $table)
            {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('mentor_category_id')
                        ->nullable()
                        ->constrained()
                        ->onDelete('set null');
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('state')->nullable();
                $table->string('city')->nullable();
                $table->string('zip_code')->nullable();
                $table->string('address')->nullable();
                $table->text('bio')->nullable();
                $table->text('skills')->nullable();
                $table->string('experience')->nullable();
                $table->string('profile_photo')->nullable();
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('mentor_profiles');
        }
    };
