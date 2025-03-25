<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Category::count() > 0) return; // if the table has data, do not seed
        $categories = [
            ['name' => 'Software Development'],
            ['name' => 'Data Science'],
            ['name' => 'Cybersecurity'],
            ['name' => 'Cloud Engineering'],
            ['name' => 'DevOps'],
            ['name' => 'Product Management'],
            ['name' => 'UI/UX Design'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
