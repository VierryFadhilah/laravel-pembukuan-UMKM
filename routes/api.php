<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsersController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/login',function () {
    return ;
})->name("login");

Route::post('/login', [LoginController::class, "index"]);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/users', [UsersController::class, "index"] );

    Route::post('/users', [UsersController::class, "store"]);

});


