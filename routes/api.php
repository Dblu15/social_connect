<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
});


Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function() {
    Route::prefix('v1')->group(function () {
        Route::apiResource('users', \App\Http\Controllers\APIControllers\UserController::class);
        Route::apiResource('posts', \App\Http\Controllers\APIControllers\PostController::class);
        Route::apiResource('comments', \App\Http\Controllers\APIControllers\CommentController::class);
        Route::apiResource('likes', \App\Http\Controllers\APIControllers\LikeController::class);
        Route::apiResource('shares', \App\Http\Controllers\APIControllers\ShareController::class);
        Route::apiResource('notifications', \App\Http\Controllers\APIControllers\NotificationController::class);
    });
    Route::post('/logout', [AuthController::class, 'logout']);
});
