<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Job;
use App\Models\Language;
use App\Models\Location;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(JobSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(JobPivotSeeder::class);
        $this->call(JobAttributeSeeder::class);
        $this->call(JobAttributesValuesSeeder::class);

    }
}
