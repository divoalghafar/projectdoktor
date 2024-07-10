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

// aset
Route::get('/form/aset', [DataController::class, 'formAset'])->name('formaset');
Route::post('/form/aset/save', [DataController::class, 'formAsetSave'])->name('form.aset.save');
Route::get('/dashboard/aset', [DataController::class, 'dashboardAset'])->name('dashboardaset');

// pengemasan
Route::get('/form/pengemasan', [DataController::class, 'formPengemasan'])->name('formpengemasan');
Route::post('/form/pengemasan/save', [DataController::class, 'formPengemasanSave'])->name('form.pengemasan.save');
Route::get('/dashboard/pengemasan', [DataController::class, 'dashboardPengemasan'])->name('dashboardpengemasan');

// gaji 
Route::get('/form/gaji', [DataController::class, 'formGaji'])->name('formgaji');
Route::post('/form/gaji/save', [DataController::class, 'formGajiSave'])->name('form.gaji.save');

// laporan akhir
Route::get('laporanakhir', [DataController::class, 'laporanAkhir'])->name('laporanakhir');

// finance 
Route::get('dashboard/finance', [DataController::class, 'dashboardFinance'])->name('dashboardfinance');

// omset 
Route::get('form/omset', [DataController::class, 'formOmset'])->name('formomset');
Route::post('form/omset/save', [DataController::class, 'formOmsetSave'])->name('form.omset.save');

// laba
Route::get('form/laba', [DataController::class, 'formLaba'])->name('formlaba');
Route::post('form/laba/save', [DataController::class, 'formLabaSave'])->name('form.laba.save');

// home
Route::get('/home', [DataController::class, 'home'])->name('home');
