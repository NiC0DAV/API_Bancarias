<?php

use App\Http\Controllers\FinancierController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiAuthMiddleware;
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

Route::post('credit/authenticate', [UserController::class, 'MSCusBilCredAuthenticateEF'])->name('authenticate');
Route::group(['middleware' => 'ApiAuthMiddleware'], function () {
    Route::post('createClient', [UserController::class, 'createClient'])->name('createClient');


});

Route::post('credit/simulate', [FinancierController::class, 'MSCusBilCredSimulateEF'])->name('simulate');

