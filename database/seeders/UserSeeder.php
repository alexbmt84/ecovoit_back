<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            "role_id" => 1,
            "establishment_id" => 1,
        ]);

        User::factory()->create([
            "role_id" => 1,
            "establishment_id" => 2,
        ]);

        User::factory()->count(10)->create([
            "role_id" => 2,
            "establishment_id" => 1,
        ]);

        User::factory()->count(10)->create([
            "role_id" => 2,
            "establishment_id" => 2,
        ]);

        User::factory()->count(300)->create([
            "role_id" => 3,
            "establishment_id" => 1,
        ]);

        User::factory()->count(300)->create([
            "role_id" => 3,
            "establishment_id" => 2,
        ]);
    }
}
