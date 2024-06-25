<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\History;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            EstablishmentSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            HistorySeeder::class,
            VehicleSeeder::class,
            TripSeeder::class,
            TripUserSeeder::class,
        ]);
    }
}
