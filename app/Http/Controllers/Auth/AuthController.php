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
        $newUser->assignRole('buyer');
        $accessToken  = $newUser->createToken('buyerToken')->accessToken;
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
            abort_if($request->user()->roles()->first()->name !== "buyer", 40);
            $accessToken = auth()->user()->createToken("buyerToken")->accessToken;
            return response()->json([
                "user" => auth()->user(),
                "access_token" => $accessToken
            ]);
        } else {
            return response()->json([
                "error" => "Wrong login credentials"
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        abort_if($request->user()->roles()->first()->name !== "buyer", 403);
        $token = $request->user()->token();
        $token->revoke();

        return response()->json([
            "status" => true,
            "success" => "User logged out successfully"
        ]);
    }

    public function me()
    {
        $me = auth()->user();
        $me['role'] = auth()->user()->roles[0];
        return response()->json([
            'me' => $me,
            'access_token' => auth()->user()->token()
        ]);
    }


    public function adminLogin()
    {
    }
}
