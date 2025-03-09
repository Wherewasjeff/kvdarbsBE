<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->with(['userAndStore:id,user_id,store_id'])->first();
        $response = $user->toArray();
        $response['store_id'] = $user->userAndStore ? $user->userAndStore->store_id : null;
        unset($response['user_and_stores']);

        // Verify user and password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        // Create a token for the authenticated user
        $token = $user->createToken('login_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $response,
        ]);
    }

    public function logout(Request $request)
    {
        // Revoke all tokens for the user
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
