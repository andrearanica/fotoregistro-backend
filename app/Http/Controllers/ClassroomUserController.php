<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassroomUser;
use Tymon\JWTAuth\Facades\JWTAuth;

class ClassroomUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ClassroomUser::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $user_id, string $classroom_id)
    {
        if (ClassroomUser::where('user_id', '=', $user_id)->where('classroom_id', '=', $classroom_id)) {
            return response()->json(['message' => 'Subscription already stored']);
        }
        return ClassroomUser::create([
            'user_id' => $user_id,
            'classroom_id' => $classroom_id,
            'role' => 'student'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $user_id, string $classroom_id)
    {
        return ClassroomUser::where('user_id', '=', $user_id)->where('classroom_id', '=', $classroom_id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $user_id, string $classroom_id)
    {
        $classroomUser = Classroomuser::where('user_id', '=', $user_id)->first();
        $classroomUser->update(['role' => $request['role']]);
        return $classroomUser;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $user_id, string $classroom_id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $classroomUserAdmin = ClassroomUser::where('user_id', '=', $user->id)->where('classroom_id', '=', $classroom_id)->first();
        if ($classroomUserAdmin->role === 'admin' || $classroomUserAdmin->id == $user_id) {
            if (!$classroomUser = ClassroomUser::where('user_id', '=', $user_id)) {
                return response()->json(['message' => 'Subscription not found'], 404);
            }
            $id = $classroomUser->first()->id;
            if (ClassroomUser::destroy($id)) {
                return response()->json(['message' => 'subscription deleted'], 200);
            } else {
                return response()->json(['message' => 'An error occoured during operation'], 400);
            }
        } else {
            return response()->json(['message' => 'Not authorized'], 403);
        }
    }
}
