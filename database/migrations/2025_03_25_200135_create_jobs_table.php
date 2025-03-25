<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description');
            $table->string('company_name', 150);

            $table->decimal('min_salary', 20, 2);
            $table->decimal('max_salary', 20, 2);

            $table->boolean('is_remote')->default(false);

            $table->enum('job_type',
                ['full-time', 'part-time', 'contract', 'freelance'])
                ->default('full-time');

            $table->enum('status',
                ['draft', 'published', 'archived'])
                ->default('draft');

            $table->timestamp('published_at')->useCurrent();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE jobs ADD COLUMN description_search_vector tsvector'); // for full-text search
        DB::statement("CREATE INDEX idx_description_search_vector ON jobs USING GIN(description_search_vector);");

        DB::statement('ALTER TABLE jobs ADD CONSTRAINT check_min_salary CHECK (min_salary >= 0)');
        DB::statement('ALTER TABLE jobs ADD CONSTRAINT check_max_salary CHECK (max_salary >= min_salary)');


        // create a stored procedure to convert the description into search vector
        DB::statement("
            CREATE OR REPLACE FUNCTION update_description_search_vector()
            RETURNS TRIGGER AS $$
            BEGIN
                NEW.description_search_vector := to_tsvector('english', NEW.description);
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ");

        // create a trigger to update the tsvector on insert/update
        DB::statement("
            CREATE TRIGGER trigger_update_description_search_vector
            BEFORE INSERT OR UPDATE ON jobs
            FOR EACH ROW EXECUTE FUNCTION update_description_search_vector();
        ");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP TRIGGER IF EXISTS trigger_update_description_search_vector ON jobs;");
        DB::statement("DROP FUNCTION IF EXISTS update_description_search_vector;");
        Schema::dropIfExists('jobs');
    }
};
