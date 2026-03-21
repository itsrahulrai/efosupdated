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
            Schema::create('jobs', function (Blueprint $table) {
                $table->id();

                // Relations
              $table->foreignId('job_category_id')
                ->constrained('job_categories')
                ->cascadeOnDelete();

                $table->foreignId('job_sub_category_id')
                    ->constrained('job_sub_categories')
                    ->cascadeOnDelete();


                // Company / Provider
                $table->string('title');
                $table->string('company_name')->nullable();
                $table->string('company_logo')->nullable(); // image
                $table->string('posted_by')->nullable();    // Opportunity Provider

                // Location
                $table->string('area')->nullable();
                $table->string('district')->nullable();
                $table->string('state')->nullable();

                // Salary
                $table->string('salary')->nullable();

                                                        // Job Meta
                $table->string('job_type')->nullable();   // Full Time / Part Time
                $table->string('work_mode')->nullable();  // WFO / WFH / Hybrid
                $table->string('shift')->nullable();      // Day / Night
                $table->string('experience')->nullable(); // Fresher / Experience
                $table->string('education')->nullable();  // 12th / Graduate

                // Additional Requirements
                $table->string('eligibility')->nullable();
                $table->string('age_limit')->nullable();
                $table->string('gender')->nullable();
                $table->string('english_level')->nullable();
                $table->text('skills')->nullable(); // comma separated or JSON

                // Description
                $table->text('short_description')->nullable();
                $table->longText('description')->nullable();

                // Highlights (JSON)
                $table->json('highlights')->nullable();

                // SEO
                $table->string('slug')->unique();

                // Status
                $table->boolean('is_featured')->default(false);
                $table->boolean('status')->default(true);
                $table->date('expiry_date')->nullable();

                $table->timestamps();
            });

        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('jobs');
        }
    };
