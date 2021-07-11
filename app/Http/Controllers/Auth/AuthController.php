<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $newUserData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'required|string',
            'address_1' => 'required|string',
            'address_2' => 'nullable|string',
            'city' => 'string|required',
            'district' => 'string|required'
        ]);
        $newUserData['password'] = bcrypt($newUserData['password']);
        $newUser = User::create($newUserData);
        $accessToken  = $newUser->createToken('authToken')->accessToken;
        return response()->json([
            'user' => $newUser,
            'access_token' => $accessToken
        ], 201);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (auth()->attempt($loginData)) {
            $accessToken = auth()->user()->createToken("authToken")->accessToken;
            return response()->json([
                "user" => auth()->user(),
                "access_token" => $accessToken
            ]);
        } else {
            return response()->json([
                "error" => "Wrong login credentials"
            ]);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        return response()->json([
            "status" => true,
            "success" => "User logged out successfully"
        ]);
    }

    public function me()
    {
        return response()->json([
            'me' => auth()->user(),
        ]);
    }
}
