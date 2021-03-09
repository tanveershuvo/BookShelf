<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SubjectController;
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

    Route::post('logout', 'AuthController@logout');
    Route::post('/auth/login', [AuthController::class,'login']);
    Route::post('/auth/register', [AuthController::class,'register']);
    Route::post('/me', [AuthController::class,'me']);
