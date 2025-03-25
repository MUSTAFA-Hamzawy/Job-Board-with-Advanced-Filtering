<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Language::count() > 0) return; // if the table has data, do not seed
        $languages = [
            'PHP', 'JavaScript', 'Python', 'Java', 'C#', 'C++', 'Ruby', 'Go',
            'Swift', 'Kotlin', 'Rust', 'TypeScript', 'Dart', 'Scala', 'Perl'
        ];

        foreach ($languages as $language) {
            Language::create(['name' => $language]);
        }
    }
}
