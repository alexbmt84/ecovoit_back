<?php

namespace Database\Factories;

use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Trip>
 */
class TripFactory extends Factory
{
    protected array $cities = [];
    protected array $establishments = [];

    public function __construct()
    {
        parent::__construct();
        $this->loadCities();
        $this->loadEstablishments();
    }

    protected function loadCities(): void
    {
        $path = storage_path('json/filtered_cities.json');
        $json = json_decode(file_get_contents($path), true);
        $this->cities = array_map(function ($item) {
            return $item['label'];
        }, $json['cities']);
    }

    protected function loadEstablishments(): void {
        $path = storage_path('json/nextech_establishments.json');
        $json = json_decode(file_get_contents($path), true);
        $this->establishments = array_map(function ($item) {
            return $item['label'];
        }, $json['establishments']);
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $min = now();
        $max = now()->addMonth();

        return [
            'departure' => $this->faker->randomElement($this->cities),
            'destination' => $this->faker->randomElement($this->establishments),
            'distance' => $this->faker->randomFloat(2, 10, 100),
            'status' => 0,
            'departure_time' => $this->faker->dateTimeBetween($min, $max),
            'vehicle_id' => rand(1, 255),
        ];
    }
}
