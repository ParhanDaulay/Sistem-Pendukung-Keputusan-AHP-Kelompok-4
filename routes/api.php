<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Login gagal'], 401);
    }

    $user = Auth::user();
    $token = $user->createToken('token-api')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token,
    ]);
});
