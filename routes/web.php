<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CargaController;
use App\Http\Controllers\ReporteController;

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
/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', function () {
    return view('welcome');
});


//ruta para cargar el archivo tco, tiene que estar en formato csv
Route::get('/cargatco',[CargaController::class,'cargatco'])->name('cargatco');
Route::get('/cargafr',[CargaController::class,'cargafr'])->name('cargafr');
Route::get('/cargans',[CargaController::class,'cargans'])->name('cargans');

Route::get('/reportetco',[ReporteController::class,'generareporte'])->name('reportetco');
Route::get('/reportetconormal',[ReporteController::class,'generareportenormal'])->name('reportetconormal');
Route::get('/reportefr',[ReporteController::class,'generareportefr'])->name('reportefr');