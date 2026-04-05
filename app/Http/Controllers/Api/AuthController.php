<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Throwable;
// use Log
use Illuminate\Support\Facades\Log;

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
            Log::info()->error('Registration error: ' . $e->getMessage(), ['exception' => $e]);
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
        $user->avatar = $user->avatar ? asset($user->avatar) : null;
        return $this->success([
            'token' => $token,
            'user'  => $user,
        ], 'Authenticated', 200);

    } catch (\Throwable $e) {
        return $this->fromException($e);
    }
}


    public function changePassword(Request $request)
    {
        try {
            $data = $request->validate([
                'current_password' => 'required|string',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $user = $request->user();

            if (! Hash::check($data['current_password'], $user->password)) {
                return $this->error('Current password is incorrect', 400);
            }

            $user->update(['password' => Hash::make($data['password'])]);

            return $this->success(null, 'Password changed successfully', 200);
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }
    public function updateProfile(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'nullable|string|max:255',
                'phone' => 'nullable|string',
                'avatar' => 'nullable|string', // comes in base64 format
            ]);
            $data['avatar'] = $this->saveBase64Image($data['avatar'] ?? null, 'avatars');
            $user = $request->user();

            $user->update($data);
            // return updated user data with full avatar URL store in storage/app/private/public/avatars
            $user->avatar = $user->avatar ? asset($user->avatar) : null; // that path is stored in the database, we need to convert it to full URL

            return $this->success($user, 'Profile updated successfully', 200); 
            
        } catch (Throwable $e) {
            return $this->fromException($e);
        }
    }

    public function saveBase64Image($base64Image, $folder)
    {
        if (! $base64Image) {
            return null;
        }

        try {
            // Extract the file extension
            preg_match('/^data:image\/(\w+);base64,/', $base64Image, $matches);
            $extension = $matches[1] ?? 'png'; // default to png if not found

            // Generate a unique filename
            $filename = uniqid() . '.' . $extension;

            // Decode the base64 string
            $imageData = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $base64Image));

            // Save the image to storage/app/public/{folder}
            $path = "public/{$folder}/{$filename}";
            \Storage::disk('public')->put("{$folder}/{$filename}", $imageData);

            // Return the URL to the saved image
            return \Storage::url("{$folder}/{$filename}");
        } catch (\Throwable $e) {
            Log::error('Error saving base64 image: ' . $e->getMessage(), ['exception' => $e]);
            return null;
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