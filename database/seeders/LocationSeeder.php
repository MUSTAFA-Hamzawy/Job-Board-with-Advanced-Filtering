<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Location::count() > 0) return; // if the table has data, do not seed
        $locations = [
            ['city' => 'New York', 'state' => 'New York', 'country' => 'USA'],
            ['city' => 'San Francisco', 'state' => 'California', 'country' => 'USA'],
            ['city' => 'London', 'state' => 'England', 'country' => 'UK'],
            ['city' => 'Berlin', 'state' => 'Berlin', 'country' => 'Germany'],
            ['city' => 'Dubai', 'state' => 'Dubai', 'country' => 'UAE'],
            ['city' => 'Tokyo', 'state' => 'Tokyo', 'country' => 'Japan'],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}
