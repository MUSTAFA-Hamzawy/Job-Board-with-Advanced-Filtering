<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Attribute::count() > 0) return;

        $attributes = [
            ['name' => 'years_experience', 'type' => 'number', 'options' => null],
            ['name' => 'remote_work_allowed', 'type' => 'boolean', 'options' => null],
            ['name' => 'job_level', 'type' => 'select', 'options' => json_encode(['junior', 'mid', 'senior'])],
            ['name' => 'industry', 'type' => 'select', 'options' => json_encode(['Tech', 'Finance', 'Healthcare', 'Marketing'])],
            ['name' => 'contract_length', 'type' => 'number', 'options' => null],
            ['name' => 'available_start_date', 'type' => 'date', 'options' => null],
        ];

        foreach ($attributes as $attribute) {
            Attribute::create($attribute);
        }
    }
}
