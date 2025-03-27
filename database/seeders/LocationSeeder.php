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
            // USA
            ['city' => 'New York', 'state' => 'New York', 'country' => 'USA'],
            ['city' => 'San Francisco', 'state' => 'California', 'country' => 'USA'],
            ['city' => 'Los Angeles', 'state' => 'California', 'country' => 'USA'],
            ['city' => 'Chicago', 'state' => 'Illinois', 'country' => 'USA'],
            ['city' => 'Austin', 'state' => 'Texas', 'country' => 'USA'],
            ['city' => 'Miami', 'state' => 'Florida', 'country' => 'USA'],

            // UK & Europe
            ['city' => 'London', 'state' => 'England', 'country' => 'UK'],
            ['city' => 'Manchester', 'state' => 'England', 'country' => 'UK'],
            ['city' => 'Berlin', 'state' => 'Berlin', 'country' => 'Germany'],
            ['city' => 'Munich', 'state' => 'Bavaria', 'country' => 'Germany'],
            ['city' => 'Paris', 'state' => 'Île-de-France', 'country' => 'France'],
            ['city' => 'Amsterdam', 'state' => 'North Holland', 'country' => 'Netherlands'],
            ['city' => 'Madrid', 'state' => 'Community of Madrid', 'country' => 'Spain'],
            ['city' => 'Barcelona', 'state' => 'Catalonia', 'country' => 'Spain'],

            // Middle East (Arabic Locations)
            ['city' => 'Cairo', 'state' => 'Cairo', 'country' => 'Egypt'],
            ['city' => 'Alexandria', 'state' => 'Alexandria', 'country' => 'Egypt'],
            ['city' => 'Riyadh', 'state' => 'Riyadh', 'country' => 'Saudi Arabia'],
            ['city' => 'Jeddah', 'state' => 'Makkah', 'country' => 'Saudi Arabia'],
            ['city' => 'Mecca', 'state' => 'Makkah', 'country' => 'Saudi Arabia'],
            ['city' => 'Medina', 'state' => 'Medina', 'country' => 'Saudi Arabia'],
            ['city' => 'Dubai', 'state' => 'Dubai', 'country' => 'UAE'],
            ['city' => 'Abu Dhabi', 'state' => 'Abu Dhabi', 'country' => 'UAE'],
            ['city' => 'Kuwait City', 'state' => 'Al Asimah', 'country' => 'Kuwait'],
            ['city' => 'Doha', 'state' => 'Doha', 'country' => 'Qatar'],
            ['city' => 'Manama', 'state' => 'Capital Governorate', 'country' => 'Bahrain'],
            ['city' => 'Muscat', 'state' => 'Muscat', 'country' => 'Oman'],
            ['city' => 'Amman', 'state' => 'Amman', 'country' => 'Jordan'],
            ['city' => 'Beirut', 'state' => 'Beirut', 'country' => 'Lebanon'],

            // Asia
            ['city' => 'Tokyo', 'state' => 'Tokyo', 'country' => 'Japan'],
            ['city' => 'Osaka', 'state' => 'Osaka', 'country' => 'Japan'],
            ['city' => 'Seoul', 'state' => 'Seoul', 'country' => 'South Korea'],
            ['city' => 'Singapore', 'state' => 'Central', 'country' => 'Singapore'],
            ['city' => 'Shanghai', 'state' => 'Shanghai', 'country' => 'China'],
            ['city' => 'Beijing', 'state' => 'Beijing', 'country' => 'China'],
            ['city' => 'Mumbai', 'state' => 'Maharashtra', 'country' => 'India'],
            ['city' => 'Bangalore', 'state' => 'Karnataka', 'country' => 'India'],
            ['city' => 'Jakarta', 'state' => 'Jakarta', 'country' => 'Indonesia'],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}
