<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\FakeCar;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->addProvider(new FakeCar($this->faker));

        return [
            'model'=> $this->faker->vehicle,
            'immatriculation'=> $this->faker->vehicleRegistration('[A-Z]{2}-[0-9]{3}-[A-Z]{2}'),
        ];
    }
}
