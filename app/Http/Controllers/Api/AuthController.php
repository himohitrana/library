<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Throwable;

class AuthController extends BaseApiController
{
    public function register(Request $request)
    {
        try {
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
                'status' => 'pending',
            ]);
            $user->syncRoles(['user']);

            $token = $user->createToken('api')->plainTextToken;

            return $this->created([
                'token' => $token,
                'user' => $user,
            ], 'Registered');
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function login_old(Request $request)
    {
        try {
            $data = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if (! Auth::attempt($data)) {
                // Invalid credentials
                return $this->error('Invalid credentials', 401);
            }

            $user = $request->user();
            $token = $user->createToken('api')->plainTextToken;

            return $this->success([
                'token' => $token,
                'user' => $user,
            ], 'Authenticated', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }
    public function login(Request $request)
{
    try {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Fetch user by email
        $user = \App\Models\User::where('email', $data['email'])->first();

        if (! $user || ! \Hash::check($data['password'], $user->password)) {
            return $this->error('Invalid credentials', 401);
        }

        // Check user status
        if ($user->status !== 'active') {
            return $this->error('User is blocked/inactive, please contact admin', 403);
        }

        // Generate token if everything is fine
        $token = $user->createToken('api')->plainTextToken;

        return $this->success([
            'token' => $token,
            'user'  => $user,
        ], 'Authenticated', 200);

    } catch (\Throwable $e) {
        return $this->fromException($e);
    }
}


    public function forgotPassword(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email']);
            // Stub: In production, trigger password reset email
            return $this->success(null, 'If the email exists, a reset link has been sent.', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $data = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            $user = User::where('email', $data['email'])->first();
            if ($user) {
                $user->update(['password' => Hash::make($data['password'])]);
            }

            return $this->success(null, 'Password has been reset if the email exists.', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            if ($user && $user->currentAccessToken()) {
                $user->currentAccessToken()->delete();
            }
            return $this->success(null, 'Logged out', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function user(Request $request)
    {
        try {
            return $this->success($request->user(), 'Current user', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }
}