<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (auth()->attempt($loginData)) {
            abort_if($request->user()->roles()->first()->name !== "merchant", 403);
            $accessToken = auth()->user()->createToken("merchantToken")->accessToken;
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
        abort_if($request->user()->roles()->first()->name !== "merchant", 403);
        $token = $request->user()->token();
        $token->revoke();

        return response()->json([
            "status" => true,
            "success" => "User logged out successfully"
        ]);
    }
}
