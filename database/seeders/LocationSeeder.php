<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            'Classroom', 'Hallway', 'Canteen', 'Restroom', 'Gymnasium',
            'School Grounds', 'Library', 'Gate / Entrance',
            'School Bus / Service', 'Online / Social Media', 'Other',
        ];

        foreach ($locations as $name) {
            Location::firstOrCreate(['name' => $name]);
        }
    }
}