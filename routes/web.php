<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// manajemen resiko
Route::get('/form/manajemenresiko', [DataController::class, 'formManajemenResiko'])->name('formmanajemenresiko');
Route::post('/form/manajemenresiko/save', [DataController::class, 'store'])->name('form.manajemenresiko.save');
Route::get('/dashboard/manajemenresiko', [DataController::class, 'dashboardManajemenResiko'])->name('dashboardmanajemenresiko');

// marketing
Route::get('/form/marketing', [DataController::class, 'formMarketing'])->name('formmarketing');
Route::post('/form/marketing/save', [DataController::class, 'formMarketingSave'])->name('form.marketing.save');
Route::get('/dashboard/marketing', [DataController::class, 'dashboardMarketing'])->name('dashboardmarketing');

// operasional
Route::get('/form/operasional', [DataController::class, 'formOperasional'])->name('formoperasional');
Route::post('/form/operasional/save', [DataController::class, 'formOperasionalSave'])->name('form.operasional.save');
Route::get('/dashboard/operasional', [DataController::class, 'dashboardOperasional'])->name('dashboardoperasional');

// home
Route::get('/home', [DataController::class, 'home'])->name('home');
