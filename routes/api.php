<?php

use App\Http\Controllers\Api\V1\ClasseController;
use App\Http\Controllers\Api\V1\CoursController;
use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\TutoringController;
use App\Http\Controllers\Api\V1\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace'=>'Api'], function(){
    // Route::any('/login','LoginController@login');
    Route::any('/login',[LoginController::class,'createUser']);
});

Route::controller(UserController::class)->group(function(){

    Route::post('/login', 'login');
    Route::post('/register', 'register');
});
Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource('/classe', ClasseController::class);
    Route::apiResource('/cours', CoursController::class);
    Route::apiResource('/tutoring', TutoringController::class);

});
