<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $validateData = $request->validate([
            'first_name' => 'required|string|max:160',
            'last_name' => 'required|string|max:160',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8|max:255',
            'phone_number' => 'required|string|max:20',
            'role_id' => 'required|integer',
            'establishment_id' => 'required|integer',
        ]);

        $user = User::create([
            'first_name' => $validateData['first_name'],
            'last_name' => $validateData['last_name'],
            'email' => $validateData['email'],
            'password' => Hash::make($validateData['password']),
            'phone_number' => $validateData['phone_number'],
            'role_id' => $validateData['role_id'],
            'establishment_id' => $validateData['establishment_id'],
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        if(!Auth::attempt($request->only('email','password'))){
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /** Permet de voir si on est bien authentifié */
    public function me(Request $request){
        return $request->user();
    }
}
