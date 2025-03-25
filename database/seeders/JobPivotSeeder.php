<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Job;
use App\Models\Language;
use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobPivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (
            DB::table('jobs_locations')->count() > 0 ||
            DB::table('jobs_languages')->count() > 0 ||
            DB::table('jobs_categories')->count() > 0
        ) { return; }

        // Fetch all job, location, language, and category IDs
        $jobIds = Job::pluck('id')->toArray();
        if (count($jobIds) == 0) return;
        $locationIds = Location::pluck('id')->toArray();
        $languageIds = Language::pluck('id')->toArray();
        $categoryIds = Category::pluck('id')->toArray();

        // jobs_location
        foreach ($jobIds as $jobId) {
            $randomLocations = array_rand(array_flip($locationIds), rand(1, 3));
            Job::find($jobId)->locations()->attach($randomLocations);
        }

        // jobs_languages
        foreach ($jobIds as $jobId) {
            $randomLanguages = array_rand(array_flip($languageIds), rand(1, 4));
            Job::find($jobId)->languages()->attach($randomLanguages);
        }

        // jobs_categories
        foreach ($jobIds as $jobId) {
            $randomCategory = $categoryIds[array_rand($categoryIds)];
            Job::find($jobId)->categories()->attach($randomCategory);
        }
    }
}
