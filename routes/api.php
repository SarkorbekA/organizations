<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckClientHasApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


//Route::get('users', [\App\Http\Controllers\UserController::class, 'index']);
//Route::get('users/{id}', [\App\Http\Controllers\UserController::class, 'show']);
//Route::delete('users/{id}', [\App\Http\Controllers\UserController::class, 'destroy']);

Route::middleware(CheckClientHasApiToken::class)->group(function () {
//    Route::apiResource('users', UserController::class);
    Route::post('users/create/', [UserController::class, 'store']);
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::match(['put', 'patch'], 'users/{id}', [UserController::class, 'update']);

    Route::get('organizations/{organization_id}/users', [UserController::class, 'getOrganizationUsers']);
    Route::get('organizations/{organization_id}/users/{user_id}', [UserController::class, 'getOrganizationUserById']);
});





//Route::apiResource('users', \App\Http\Controllers\UserController::class)->middleware(\App\Http\Middleware\CheckClientHasApiToken::class);
//Route::get('organization')
