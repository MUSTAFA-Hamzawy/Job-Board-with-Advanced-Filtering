<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      if (Job::count() > 0) return; // if the table has data, do not seed

        $jobsData = include database_path("data/job-seeder.php");

        foreach ($jobsData as $job) {
            Job::create([
                'title' => $job['title'],
                'description' => $job['description'],
                'company_name' => fake()->company(),
                'min_salary' => fake()->numberBetween(30000, 60000),
                'max_salary' => fake()->numberBetween(60000, 120000),
                'is_remote' => fake()->boolean(),
                'job_type' => fake()->randomElement(['full-time', 'part-time', 'contract', 'freelance']),
                'status' => fake()->randomElement(['draft', 'published', 'archived']),
                'published_at' => now(),
            ]);
        }
    }
}
