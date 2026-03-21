    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('job_sub_categories', function (Blueprint $table) {
                $table->id();

                $table->foreignId('job_category_id')
                    ->constrained('job_categories')
                    ->cascadeOnDelete();

                $table->string('name');
                $table->string('slug')->unique();
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('job_sub_categories');
        }
    };
