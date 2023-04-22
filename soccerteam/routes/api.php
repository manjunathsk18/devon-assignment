<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;
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

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
Route::get('team-players-list/{id}', [TeamController::class, 'teamPlayersList']);
Route::resource('teams', TeamController::class, ['only' => ['index', 'show']]);


Route::group(['middleware' => 'auth:api'], function () { 
    Route::resource('teams', TeamController::class, ['except' => ['index', 'show']]); 
});

Route::resource('players', PlayerController::class, ['only' => ['index', 'show']]);

Route::group(['middleware' => 'auth:api'], function () { 
    Route::resource('players', PlayerController::class, ['except' => ['index', 'show']]); 
});



