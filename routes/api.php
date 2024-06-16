<?php

use App\Http\Controllers\API\Authentication\AuthenticationController;
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

// Authentication API
// Authentication API
Route::prefix('auth')->middleware('auth:sanctum')->name('auth.')->group(function () {
    Route::post('login', [AuthenticationController::class, 'login'])->name('login')->withoutMiddleware('auth:sanctum');
    Route::get('current-user', [AuthenticationController::class, 'currentUser'])->name('current-user');
    Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
});
