<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

Route::middleware(['apiJWT'])->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::prefix('events')->group(function() {
        Route::get('/', [EventController::class, 'get']);
        Route::get('/{id}', [EventController::class, 'getByID']);
        Route::post('/create', [EventController::class, 'create']);
        Route::delete('/delete/{id}', [EventController::class, 'delete']);

        Route::post('/{id}/comments/create', [EventController::class, 'comment']);
        Route::put('/{id}/participate', [EventController::class, 'participate']);
        Route::put('/{id}/departicipate', [EventController::class, 'departicipate']);
        Route::post('/{id}/rating', [EventController::class, 'rating']);
    });
});

