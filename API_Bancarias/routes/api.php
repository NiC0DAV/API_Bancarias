<?php

use App\Http\Controllers\CreditInscriptionController;
use App\Http\Controllers\FinancierController;
use App\Http\Controllers\UserController;
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
<<<<<<< HEAD
Route::post('credit/inscription', [CreditInscriptionController::class, 'MSCusBilCredInscriptionEF'])->name('inscription');
=======

Route::post('credit/simulate', [FinancierController::class, 'MSCusBilCredSimulateEF'])->name('simulate');

>>>>>>> dedc25bc91ba75bd867b02dedf0158af35e55b10
