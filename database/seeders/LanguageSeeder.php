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
            // Popular Backend & General Purpose
            'PHP', 'JavaScript', 'Python', 'Java', 'C#', 'C++', 'Ruby', 'Go',
            'Swift', 'Kotlin', 'Rust', 'TypeScript', 'Dart', 'Scala', 'Perl',

            // Systems & Low-Level
            'C', 'Objective-C', 'Zig', 'Nim', 'Assembly', 'Fortran',

            // Functional
            'Elixir', 'Erlang', 'Haskell', 'F#', 'Clojure',

            // Scripting & Web
            'Lua', 'Shell', 'Bash', 'PowerShell',

            // Data & Scientific Computing
            'R', 'Julia', 'MATLAB',

            // Database & Query Languages
            'SQL', 'PL/SQL', 'GraphQL',

            // Embedded & Hardware
            'VHDL', 'Verilog', 'Ada',

            // Mobile & UI
            'Flutter', 'React Native', 'Xamarin',

            // Emerging & Alternative
            'Crystal', 'Forth', 'COBOL', 'Lisp',

            // Game Development
            'GDScript', 'Godot', 'Haxe',

            // Blockchain & Smart Contracts
            'Solidity', 'Vyper',

            // AI & Machine Learning
            'Prolog', 'Lisp', 'Jupyter Notebook'
        ];

        foreach ($languages as $language) {
            Language::create(['name' => $language]);
        }
    }
}
