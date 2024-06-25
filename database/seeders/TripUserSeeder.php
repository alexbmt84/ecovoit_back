<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\TripUser;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class TripUserSeeder extends Seeder
{
    public function run(): void
    {
        $trips = Trip::all();
        $userId = 23;

        for ($i = 0; $i < count($trips); $i++) {

            $vehicle = new Vehicle();
            $tripUser = new TripUser();

            for ($j = 0; $j < 1; $j++) {

                $tripId = $trips[$i]->id;
                $vehicleId = $trips[$i]->findVehicleId($tripId);
                $totalPassengers = $tripUser->findTotalPassengers($tripId);
                $totalSeats = $vehicle->findTotalSeats($vehicleId);
                $status = $tripUser->determineRole($tripId);

                if($status !== $tripUser->passengerStatus) {
                    $tripUser->createDriver($userId, $tripId);
                    $userId++;
                }

                while ($totalSeats > $totalPassengers) {
                    $tripUser->createPassenger($userId, $tripId);
                    $totalPassengers ++;
                    $userId ++;
                }
            }
        }
    }
}
