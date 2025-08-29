<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);
        // Create new user and assign role "user"
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
        ]);
        $user->syncRoles(['user']);

        $token = $user->createToken('api')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($data)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = $request->user();
        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        // Stub: In production, trigger password reset email
        return response()->json(['message' => 'If the email exists, a reset link has been sent.']);
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        $user = User::where('email', $data['email'])->first();
        if ($user) {
            $user->update(['password' => Hash::make($data['password'])]);
        }
        return response()->json(['message' => 'Password has been reset if the email exists.']);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }
        return response()->json(['message' => 'Logged out']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}