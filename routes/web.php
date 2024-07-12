<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

use App\Http\Controllers\KriteriaController;

Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
Route::post('/kriteria', [KriteriaController::class, 'store'])->name('kriteria.store');
Route::put('/kriteria/{kriteria}', [KriteriaController::class, 'update'])->name('kriteria.update');
Route::delete('/kriteria/{kriteria}', [KriteriaController::class, 'destroy'])->name('kriteria.destroy');


use App\Http\Controllers\AlternatifController;

Route::get('/alternatifs', [AlternatifController::class, 'index'])->name('alternatif.index');
Route::post('/alternatifs', [AlternatifController::class, 'store'])->name('alternatifs.store');
Route::put('/alternatifs/{alternatif}', [AlternatifController::class, 'update'])->name('alternatifs.update');
Route::delete('/alternatifs/{alternatif}', [AlternatifController::class, 'destroy'])->name('alternatifs.destroy');


use App\Http\Controllers\PenilaianController;

Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
Route::post('/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');
Route::put('/penilaian/{id}', [PenilaianController::class, 'update'])->name('penilaian.update');


Route::get('/perhitungan/topsis', [PenilaianController::class, 'topsis'])->name('perhitungan.topsis');


Route::get('/about', function () {
    return view('about');
})->name('about');
