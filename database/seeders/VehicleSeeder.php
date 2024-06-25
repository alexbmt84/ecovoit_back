<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 255; $i++) {

            Vehicle::factory()->create([
                'places' => rand(1,3),
                'user_id' => rand(23, 622), 
            ]);

        }
    }
}
