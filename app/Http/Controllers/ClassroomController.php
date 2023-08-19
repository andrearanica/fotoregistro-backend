<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Models\ClassroomUser;
use Tymon\JWTAuth\Facades\JWTAuth;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Classroom::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $user = JWTAuth::parseToken()->authenticate();
        $classroom = Classroom::create($request->all()); 
        ClassroomUser::create([
            'user_id' => $user->id,
            'classroom_id' => $classroom->id,
            'role' => 'admin'
        ]);
        return $classroom;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Classroom::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $classroom = Classroom::find($id);
        $classroom->update($request->all());
        return $classroom;
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param string $id
     */
    public function destroy(string $id)
    {
        return Classroom::destroy($id);
    }

    /**
     * Search a classroom from a similar name (using SQL like)
     * 
     * @param string $name
     */
    public function search (string $name)
    {
        return Classroom::where('name', 'like', "%$name%")->get();
    }

    public function users (Request $request, string $id)
    {
        if (!$classroom = Classroom::find($id)) {
            return response()->json(['message' => 'Class not found'], 404);
        }
        return $classroom->users;
    }
}