<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KopiController;

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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::match(['get', 'post'], '/', [AuthController::class, 'guest'])->name('login');

Route::group([
    'middleware' => 'json'
], function(){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function(){
        Route::resource('/kopi', KopiController::class);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
