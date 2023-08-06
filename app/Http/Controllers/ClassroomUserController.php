<?php

namespace App\Http\Controllers;

use App\Models\ClassroomUser;
use Illuminate\Http\Request;

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
        return ClassroomUser::where('user_id', '=', $user_id)->where('classroom_id', '=', $classroom_id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
