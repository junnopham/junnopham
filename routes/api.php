<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    Route::post('login', [AuthController::class, 'login']);

    Route::get('post/{hash}', [PostController::class, 'show']);

    Route::get('user', [AuthController::class, 'user'])->middleware('auth:api');

    Route::group(['prefix' => 'post','middleware' => ['auth:api']], function () {

        Route::get('logout', [AuthController::class, 'logout']);
    });
});
