<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(): JsonResponse {

        $validated = request()->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User :: create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash :: make($validated['password']),
        ]);

        $token = $user -> createToken(name: 'auth_token') -> plainTextToken;

        //return
        return response()->json(data:[
            'access_token' => $token,
            'user' => $user,
            'token_type' => 'Bearer',
        ]);
    }
}
