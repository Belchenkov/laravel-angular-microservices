<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            if (!$user) {
                response(['User not found'], Response::HTTP_NOT_FOUND);
            }

            $token = $user->createToken('admin')->accessToken;

            return [
                'token' => $token
            ];
        }

        return response(['error' => 'Invalid Credentials'], Response::HTTP_UNAUTHORIZED);
    }
}
