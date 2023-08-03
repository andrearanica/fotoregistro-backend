<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     * Check if the credentials (email and password) are right and return a token
     * 
     * @param Request $request
     */
    public function authenticate (Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token', 500]);
        }

        return response()->json(compact('token'));
    }

    /**
     * Register a new user into the database
     * 
     * @param Request $request
     */
    public function register (Request $request) 
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required'
        ]);

        $user = User::create($request->all());
        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }
}
