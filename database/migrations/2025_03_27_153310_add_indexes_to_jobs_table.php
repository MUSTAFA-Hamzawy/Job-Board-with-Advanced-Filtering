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
        Schema::table('jobs', function (Blueprint $table) {
            $table->index('job_type', 'idx_jobs_job_type');
            $table->index('published_at', 'idx_jobs_published_at');
            $table->index(['job_type', 'is_remote'], 'idx_jobs_job_type_is_remote');
            $table->index(['min_salary', 'max_salary'], 'idx_jobs_salary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropIndex('idx_jobs_job_type');
            $table->dropIndex('idx_jobs_published_at');
            $table->dropIndex('idx_jobs_job_type_is_remote');
            $table->dropIndex('idx_jobs_salary');
        });
    }
};
