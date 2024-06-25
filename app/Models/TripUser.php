<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TripUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    public string $driverStatus = "Driver";
    public string $passengerStatus  = "Passenger";

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function createDriver($userId, $tripId) {
        TripUser::create([
            "user_id" => $userId,
            "trip_id" => $tripId,
            "status" => $this->driverStatus,
        ]);
    }

    public function createPassenger($userId, $tripId) {
        TripUser::create([
            "user_id" => $userId,
            "trip_id" => $tripId,
            "status" => $this->passengerStatus,
        ]);
    }

    public function findIfDriverExists($tripId) {
        $counter = TripUser::query()->where('trip_id', $tripId)
            ->where('status', $this->driverStatus)
            ->count();

        return $counter > 0;
    }

    public function findTotalPassengers($tripId) {
        return TripUser::query()->where('trip_id', $tripId)
            ->where('status', $this->passengerStatus)
            ->count();
    }

    public function determineRole($tripId) {

        $driverExists = $this->findIfDriverExists($tripId);

        $driverExists ?
            $status = $this->passengerStatus :
            $status = $this->driverStatus;

        return $status;
    }

}
