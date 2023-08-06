<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

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
                return response()->json(['error' => 'Invalid credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token', 500]);
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
            'password' => 'required',
            'email' => 'required'
        ]);

        $user = User::create($request->all());
        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    /**
     * Return authenticated user's info
     * 
     */
    public function getAuthenticatedUser () 
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token expired'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token not valid'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token not found'], 401);
        }
        return response()->json(compact('user'));
    }

    /**
     * Update user's info
     * 
     * @param Request $request, string $id
     */
    public function update (Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $user->update($request->all());
        return $user;
    }

    /**
     * Subscribe user to classroom
     * 
     * @param Request $request, string $class_id
     */
    public function subscribe (Request $request, string $classroom_id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if (Classroom::find($classroom_id)) {
            return $user->update([
                'classroom_id' => $classroom_id
            ]);
        }
        return response()->json(['data' => 'Class not found'], 404);
    }

    /**
     * Unsusbscribe user from classroom
     * 
     * @param Request $request
     */
    public function unsubscribe (Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        return $user->update([
            'classroom_id' => null
        ]);
    }

    public function classrooms (Request $request, string $id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user == User::find($id)) {
            return $user->classrooms;
        } else {
            return response()->json(['message' => 'Wrong user id'], 401);
        }
    }
}
