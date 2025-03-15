<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Các route API sẽ được load từ file này. Bạn có thể định nghĩa các endpoint
| dành cho API của mình ở đây. Các route trong file này thường được áp dụng middleware "api".
|
*/

Route::prefix('v1')->group(function () {
    Route::apiResource('users', \App\Http\Controllers\Api\UserController::class);
    Route::apiResource('posts', \App\Http\Controllers\Api\PostController::class);
});
