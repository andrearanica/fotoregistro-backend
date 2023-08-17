<?php

use App\Http\Controllers\ClassroomUserController;
use App\Http\Controllers\ImageUploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClassroomController;
use App\Http\Middleware\CheckAuthenticatedUser;

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
    
    Route::middleware([CheckAuthenticatedUser::class])->group(function () {
        Route::get('users/{id}', [UserController::class, 'show']);
        Route::put('users/{id}', [UserController::class, 'update']);
        Route::post('users/{id}/photo', [ImageUploadController::class, 'storeImage']);
        Route::get('users/{id}/photo', [ImageUploadController::class, 'getImage']);
    });
    
    Route::resource('classrooms', ClassroomController::class);

    Route::get('classrooms/{id}/users', [ClassroomController::class, 'users']);
    
    Route::get('users/{id}/classrooms', [UserController::class, 'classrooms'])->middleware(CheckAuthenticatedUser::class);
    Route::post('classroom/subscribe/{classroom_id}', [UserController::class, 'subscribe']);
    Route::put('classroom/unsubscribe', [UserController::class, 'unsubscribe']);
    Route::post('users/{user_id}/classrooms/{classroom_id}', [ClassroomUserController::class, 'store']);
    Route::put('users/{user_id}/classrooms/{classroom_id}', [ClassroomUserController::class, 'update']);
    Route::get('users/{user_id}/classrooms/{classroom_id}', [ClassroomUSerController::class, 'show']);
    Route::delete('users/{user_id}/classrooms/{classroom_id}', [ClassroomUserController::class, 'destroy']);

});

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'authenticate']);