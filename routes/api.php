<?php

use App\Http\Controllers\ClassroomUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClassroomController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::resource('classrooms', ClassroomController::class);
    Route::get('classrooms/search/{name}', [ClassroomController::class, 'search']);
    Route::get('classrooms/{id}/users', [ClassroomController::class, 'users']);
    Route::get('users/{id}/classroom', [UserController::class, 'classrooms']);
    Route::post('classroom/subscribe/{classroom_id}', [UserController::class, 'subscribe']);
    Route::put('classroom/unsubscribe', [UserController::class, 'unsubscribe']);
    Route::post('users/{user_id}/classrooms/{classroom_id}', [ClassroomUserController::class, 'store']);
    Route::get('users/{user_id}/classrooms/{classroom_id}', [ClassroomUSerController::class, 'show']);
});

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'authenticate']);
Route::get('auth-info', [UserController::class, 'getAuthenticatedUser']);
Route::put('users', [UserController::class, 'update']);