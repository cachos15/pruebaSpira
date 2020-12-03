<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ClassByUserController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resource('user', UserController::class);
Route::resource('classes', ClassesController::class);
Route::resource('classByUser', ClassByUserController::class);

Route::post('/login', [UserController::class, 'login']);
Route::post('/getClassesByUser', [ClassByUserController::class, 'getClassesByUser']);


