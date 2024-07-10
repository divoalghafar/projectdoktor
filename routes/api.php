<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/data', [DataController::class, 'api']);
Route::get('/marketing', [DataController::class, 'apiMarketing']);
Route::get('/operasional', [DataController::class, 'apiOperasional']);
Route::get('/aset', [DataController::class, 'apiAset']);
Route::get('/pengemasan', [DataController::class, 'apiPengemasan']);
Route::get('/gaji', [DataController::class, 'apiGaji']);
Route::get('/omset', [DataController::class, 'apiOmset']);
Route::get('/laba', [DataController::class, 'apiLaba']);