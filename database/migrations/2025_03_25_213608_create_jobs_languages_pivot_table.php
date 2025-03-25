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
        Schema::create('jobs_languages', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->foreignId('job_id')->constrained('jobs')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedSmallInteger('language_id');
            $table->foreign('language_id')->references('id')->on('languages')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs_languages');
    }
};
