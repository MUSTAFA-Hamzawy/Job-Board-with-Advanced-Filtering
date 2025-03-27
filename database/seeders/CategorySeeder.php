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
        if (Category::count() > 0) return; // If the table has data, do not seed

        $categories = [
            ['name' => 'Software Development'],
            ['name' => 'Data Science'],
            ['name' => 'Cybersecurity'],
            ['name' => 'Cloud Engineering'],
            ['name' => 'DevOps'],
            ['name' => 'Product Management'],
            ['name' => 'UI/UX Design'],
            ['name' => 'Backend Development'],
            ['name' => 'Frontend Development'],
            ['name' => 'Full-Stack Development'],
            ['name' => 'Web Development'],
            ['name' => 'Mobile App Development'],
            ['name' => 'Game Development'],
            ['name' => 'Embedded Systems'],
            ['name' => 'Desktop Software Development'],
            ['name' => 'AI & Machine Learning'],
            ['name' => 'Blockchain Development'],
            ['name' => 'Networking & IT Support'],
            ['name' => 'System Administration'],
            ['name' => 'Technical Writing'],
            ['name' => 'Quality Assurance (QA)'],
            ['name' => 'Database Administration'],
            ['name' => 'Big Data Engineering'],
            ['name' => 'E-commerce Development'],
            ['name' => 'Business Intelligence'],
            ['name' => 'Software Testing'],
            ['name' => 'Security Analysis'],
            ['name' => 'IT Project Management'],
            ['name' => 'AR/VR Development']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
