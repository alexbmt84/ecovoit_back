<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index() {
        $vehicles = Vehicle::all();
        return response()->json($vehicles);
    }

    public function store(Request $request) {
        try {
            $validateData = $request->validate([
                'model' => 'required|string|max:160',
                'immatriculation' => 'required|string|max:160',
                'places' => 'required|integer',
                'picture' => 'nullable|string',
            ]);

            $vehicle = Vehicle::create([
                'model' => $validateData['model'],
                'immatriculation' => $validateData['immatriculation'],
                'places' => $validateData['places'],
                'picture' => $validateData['picture']??null,
                'user_id' => auth()->id()
            ]);

            return response()->json($vehicle);
        } catch (\Exception) {

            return response()->json(['message' => 'Error while trying to save vehicle.'], 422);
        }
    }

    public function read($vehicleId) {

        $vehicle = Vehicle::query()->where('id', $vehicleId)->first();

        if(!$vehicle) {
            return response()->json(['message' => 'No vehicle found.'], 404);
        }

        return response()->json($vehicle);
    }

    public function update(Request $request, $id)
    {
        try {

            $vehicle = Vehicle::findOrFail($id);

            $validateData = $request->validate([
                'model' => 'required|string|max:160',
                'immatriculation' => 'required|string|max:160',
                'places' => 'required|integer',
                'picture' => 'nullable|string',
            ]);

            $vehicle->update([
                'model' =>  $validateData['model'],
                'immatriculation' => $validateData['immatriculation'],
                'places' => $validateData['places'],
                'picture' => $validateData['picture']??null,
                'user_id' => auth()->id()
            ]);

            return response()->json($vehicle);

        } catch (\Exception) {

            return response()->json(['message' => 'Error while trying to update vehicle.'], 422);
        }
    }

    public function delete($vehicleId)
    {
        try {

            $vehicle = Vehicle::findOrFail($vehicleId);
            $vehicle->delete();

            return response()->json(['message' => 'Vehicle has been successfully deleted.']);

        } catch (\Exception) {

            return response()->json(['message' => 'Error while trying to delete vehicle.'], 422);
        }
    }
}
