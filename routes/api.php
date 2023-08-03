<?php

use Illuminate\Http\Request;
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

/* Route::get('/classrooms', [ClassroomController::class, 'index']);

Route::get('classrooms/{id}', [ClassroomController::class, 'search']);

Route::post('/classrooms', [ClassroomController::class, 'store']); */

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::resource('classrooms', ClassroomController::class);
Route::get('classrooms/search/{name}', [ClassroomController::class, 'search']);
});

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'authenticate']);