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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->enum('type', ['text', 'number', 'boolean', 'date', 'select']);
            $table->jsonb('options')->nullable();
            $table->timestamps();
        });

        DB::statement('CREATE INDEX idx_attributes_options ON attributes USING GIN (options);');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
