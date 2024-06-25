<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Http;

class Trip extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'trip_users')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function tripUsers(): HasMany
    {
        return $this->hasMany(TripUser::class);
    }

    public function findVehicleId($tripId)
    {
        return Trip::query()->where('id', $tripId)
            ->value('vehicle_id');
    }


    public function isFull(): bool
    {
        $totalPassengers = $this->tripUsers()->count();
        $totalSeats = $this->vehicle->findTotalSeats($this->vehicle->id);

        return $totalPassengers >= $totalSeats;
    }

    public function findTotalPassengers()
    {
        return TripUser::where('trip_id', $this->id)->where('status', 'Passenger')->count();
    }

    public function findDriverName($tripId) {
        $driverId = TripUser::query()
            ->where('trip_id', $tripId)
            ->where('status', 'Driver')
            ->pluck('user_id');

        return User::query()->where('id', $driverId)->pluck('first_name');
    }

    public function getCoordinates($locationName): ?array
    {
        $apiKey = 'AIzaSyDxnbqlXcwX93UYD9GqYzX2g_-N01zL33c';
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($locationName) . "&key=" . $apiKey;

        $response = Http::get($url);
        $data = $response->json();
        if (empty($data['results'])) {
            return null;
        }

        return [
            'lat' => $data['results'][0]['geometry']['location']['lat'],
            'lng' => $data['results'][0]['geometry']['location']['lng'],
        ];
    }

    public function findNearestTrips(array $coords)
    {
        $latitude = $coords['lat'];
        $longitude = $coords['lng'];

        // Formule Haversine
        return Trip::select('*')
            ->selectRaw("*, (6371 * acos(
                        cos(radians(?))
                        * cos(radians(latitude))
                        * cos(radians(longitude) - radians(?))
                        + sin(radians(?))
                        * sin(radians(latitude))
                    )) AS distance", [$latitude, $longitude, $latitude])
            ->having('distance', '<', 50) // Filtrer pour obtenir les trajets dans un rayon de 50 km
            ->orderBy('distance', 'asc')
            ->get();
    }

}
