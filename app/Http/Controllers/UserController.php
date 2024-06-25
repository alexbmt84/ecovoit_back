<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {

        try {

            $users = User::all();
            return response()->json($users);

        } catch (\Exception) {
            return response()->json(['message' => 'Cannot find user.']);
        }

    }

    public function read($userId): \Illuminate\Http\JsonResponse
    {

        try {

            $user = User::query()->where('id', $userId)->firstOrFail();
            return response()->json($user);


        } catch (\Exception) {
            return response()->json(['message' => 'Cannot find user.']);
        }

    }

    public function update($userId, Request $request): \Illuminate\Http\JsonResponse
    {

        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        try {
            $rules = [
                'first_name' => 'string|max:160',
                'last_name' => 'string|max:160',
                'email' => 'string|email|max:255|unique:users,email,' . $user->id,
                'phone_number' => 'string|max:20',
                'role_id' => 'integer|max:20',
                'establishment_id' => 'integer|max:20',
                'avatar' => 'string|max:255',
                'active_status' => 'integer|min:0|max:1',
                'dark_mode' => 'integer|min:0|max:1'
            ];

            $validations = array_filter($rules, function ($key) use ($request) {
                return $request->has($key);
            }, ARRAY_FILTER_USE_KEY);

            $validatedData = $request->validate($validations);

            $user->update($validatedData);

            return response()->json($user);

        } catch (\Exception $e) {
            Log::error('User update error: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 400);
        }

    }

    public function delete($userId): \Illuminate\Http\JsonResponse
    {

        try {

            $user = User::query()->where('id', $userId)->firstOrFail();
            $user->delete();

            return response()->json(['message' => 'User has been successfully deleted.']);

        } catch (\Exception) {

            return response()->json(['message' => 'Error while trying to delete User.'], 400);

        }

    }

}
