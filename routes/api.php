<?php

use App\Http\Controllers\FuelSensorController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
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


Route::middleware(CheckClientHasApiToken::class)->group(callback: function () {
    //    Users Routes
    Route::post('users', [UserController::class, 'store']);
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
    Route::match(['put', 'patch'], 'users/{id}', [UserController::class, 'update']);

    //    Organizations Routes
    Route::post('organizations', [OrganizationController::class, 'store']);
    Route::get('organizations', [OrganizationController::class, 'index']);
    Route::get('organizations/{id}', [OrganizationController::class, 'show']);
    Route::delete('organizations/{id}', [OrganizationController::class, 'destroy']);
    Route::match(['put', 'patch'], 'organizations/{id}', [OrganizationController::class, 'update']);

    //    Organizations Users Routes
    Route::get('organizations/{organization_id}/users', [OrganizationController::class, 'getOrganizationUsers']);
    Route::get('organizations/{organization_id}/users/{user_id}', [OrganizationController::class, 'getOrganizationUserById']);

    //    Organizations Vehicles Routes
    Route::get('organizations/{organization_id}/vehicles', [OrganizationController::class, 'getOrganizationVehicles']);
    Route::get('organizations/{organization_id}/vehicles/{vehicle_id}', [OrganizationController::class, 'getOrganizationVehicleById']);

    //    Vehicles Routes
    Route::post('vehicles', [VehicleController::class, 'store']);
    Route::get('vehicles', [VehicleController::class, 'index']);
    Route::get('vehicles/{id}', [VehicleController::class, 'show']);
    Route::delete('vehicles/{id}', [VehicleController::class, 'destroy']);
    Route::match(['put', 'patch'], 'vehicles/{id}', [VehicleController::class, 'update']);

    //    Vehicle FuelSensors Routes
    Route::get('vehicles/{vehicle_id}/fuel_sensors', [VehicleController::class, 'getVehicleFuelSensors']);
    Route::get('vehicles/{vehicle_id}/fuel_sensors/{fuel_sensor_id}', [VehicleController::class, 'getVehicleFuelSensorsById']);

    //    FuelSensor Routes
    Route::post('fuel_sensors', [FuelSensorController::class, 'store']);
    Route::get('fuel_sensors', [FuelSensorController::class, 'index']);
    Route::get('fuel_sensors/{id}', [FuelSensorController::class, 'show']);
    Route::delete('fuel_sensors/{id}', [FuelSensorController::class, 'destroy']);
    Route::match(['put', 'patch'], 'fuel_sensors/{id}', [FuelSensorController::class, 'update']);
});




//Route::apiResource('users', \App\Http\Controllers\UserController::class)->middleware(\App\Http\Middleware\CheckClientHasApiToken::class);
//Route::get('organization')

