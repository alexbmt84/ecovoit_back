<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\TripUser;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class TripController extends Controller
{
    public function index(Request $request): JsonResponse
    {

        $limit = $request->input('limit');
        $departure = $request->query('departure');
        $arrival = $request->query('arrival');
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');
        $passengers = $request->query('passengers');

        $query = Trip::with(['users', 'vehicle', 'tripUsers']);

        $query->where(function ($q) use ($departure, $arrival) {
                $q->where('departure', 'LIKE', "%$departure%")
                ->orWhere('destination', 'LIKE', "%$arrival%");
        });

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        $trips = $query->get();

        if ($trips->isEmpty()) {
            return response()->json(['message' => 'No trips found.'], 404);
        }

        foreach ($trips as $trip) {
            $trip->isFull = $trip->isFull();
            $trip->totalPassengers = $trip->findTotalPassengers($trip->id);
            $trip->driverName = $trip->findDriverName($trip->id);
        }

        return response()->json($trips);
    }


    public function read($tripId): JsonResponse
    {

        $trip = Trip::query()
            ->with(['users', 'vehicle'])
            ->where('id', $tripId)
            ->first();

        if (!$trip) {
            return response()->json(['message' => 'No trip found.'], 404);
        }

        return response()->json($trip);
    }

    public function delete($tripId): JsonResponse
    {

        try {

            $trip_users = TripUser::query()->where('trip_id', $tripId);
            $trip = Trip::query()->findOrFail($tripId);

            $trip_users->delete();
            $trip->delete();

            return response()->json(['message' => 'Trip has been successfully deleted.']);

        } catch (\Exception) {

            return response()->json(['message' => 'Error while trying to delete trip.'], 400);

        }

    }

    public function store(Request $request): JsonResponse
    {

        try {

            $userId = auth()->id();

            $validateData = $request->validate([
                'departure' => 'required|string|max:255',
                'destination' => 'required|string|max:255',
                'distance' => 'required|numeric|min:0',
                'departure_time' => 'required|date|after:now',
                'vehicle_id' => 'required|integer|min:1',
            ]);


            $trip = Trip::query()->create([
                'departure' => $validateData['departure'],
                'destination' => $validateData['destination'],
                'distance' => $validateData['distance'],
                'departure_time' => $validateData['departure_time'],
                'vehicle_id' => $validateData['vehicle_id'],
            ]);

            $tripUser = TripUser::query()->create([
                'user_id' => $userId,
                'trip_id' => $trip->id,
                'status' => "Driver"
            ]);

            return response()->json(['trip' => $trip, 'trip_user' => $tripUser]);

        } catch (\Exception) {

            return response()->json(['message' => 'Error while trying to save trip.'], 400);

        }

    }

    public function update(Request $request, $id): JsonResponse
    {
        try {

            $trip = Trip::query()->findOrFail($id);

            $validateData = $request->validate([
                'departure' => 'required|string|max:255',
                'destination' => 'required|string|max:255',
                'distance' => 'required|numeric|min:0',
                'status' => 'required|numeric|min:0|max:2',
                'departure_time' => 'required|date|after:now',
                'vehicle_id' => 'required|integer|min:0',
            ]);

            $trip->update([
                'departure' => $validateData['departure'],
                'destination' => $validateData['destination'],
                'distance' => $validateData['distance'],
                'status' => $validateData['status'],
                'departure_time' => $validateData['departure_time'],
                'vehicle_id' => $validateData['vehicle_id'],
            ]);

            return response()->json($trip);


        } catch (\Exception) {

            return response()->json(['message' => 'Error while trying to update trip.'], 400);

        }

    }

    public function getUserTrips()
    {
        try {
            $user = auth()->user();
            $trips = $user->trips()->with(['users', 'vehicle'])->get();

            if ($trips->isEmpty()) {
                return response()->json(['message' => 'Vous n\'avez actuellement pas de trajet.'], 404);
            }

            return response()->json($trips);
        } catch (\Exception $e) {
            Log::error('User trips error: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

}
