<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TripUser>
 */
class TripUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $table = 'trips_users';
    protected $guarded = [];

    public function definition(): array
    {
        return [
            //
        ];
    }
}
