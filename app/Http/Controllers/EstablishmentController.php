<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Establishment;

class EstablishmentController extends Controller
{

    /**
     * Display all establishments.
     *
     * @return JsonResponse
     */

    public function index(): JsonResponse
    {
        $establishments = Establishment::all();

        if (!$establishments) {
            return response()->json(["message" => "No establishments found"], 400);
        }

        return response()->json($establishments);
    }

    /**
     * Display all establishments.
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function store(Request $request): JsonResponse
    {

        try {

            $validateData = $request->validate([
                'name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20',
                'adress' => 'required|string|max:255',
                'postal_code' => 'required|string|max:20',
                'city' => 'required|string|max:255'
            ]);

            $establishment = Establishment::query()->create([
                'name' => $validateData['name'],
                'phone_number' => $validateData['phone_number'],
                'adress' => $validateData['adress'],
                'postal_code' => $validateData['postal_code'],
                'city' => $validateData['city'],
            ]);

            return response()->json($establishment);

        } catch (\Exception) {
            return response()->json(['message' => 'Error while saving establishment'], 400);
        }

    }

    /**
     * Return the establishment.
     *
     * @param int $id
     * @return JsonResponse
     */

    public function show(int $id): JsonResponse
    {

        $establishment = Establishment::query()->find($id);

        if (!$establishment) {
            return response()->json(['message' => 'No establishment found.'], 400);
        }

        return response()->json($establishment);
    }

    /**
     * Update the specified establishment.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */

    public function update(Request $request, int $id): JsonResponse
    {
        try {

            $establishment = Establishment::query()->find($id);

            if (!$establishment) {
                return response()->json(['message' => 'No establishment found.'], 400);
            }

            $validateData = $request->validate([
                'name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20',
                'adress' => 'required|string|max:255',
                'postal_code' => 'required|string|max:20',
                'city' => 'required|string|max:255'
            ]);

            $establishment->update([
                'name' => $validateData['name'],
                'phone_number' => $validateData['phone_number'],
                'adress' => $validateData['adress'],
                'postal_code' => $validateData['postal_code'],
                'city' => $validateData['city'],
            ]);

            return response()->json($establishment);


        } catch (\Exception) {

            return response()->json(['message' => 'Error while trying to update establishment.'], 400);

        }
    }

    /**
     * Delete the establishment.
     *
     * @param int $id
     * @return JsonResponse
     */

    public function delete(int $id): JsonResponse
    {
        $establishment = Establishment::query()->find($id);

        if (!$establishment) {
            return response()->json(['message' => 'This establishment does not exist.'], 400);
        }

        $establishment->delete();

        return response()->json(['message' => "The establishment has been successfully deleted."]);
    }

}
