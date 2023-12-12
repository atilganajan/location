<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;

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

Route::get('/', [LocationController::class,"index"])->name("index");

Route::prefix('location')->name('location.')->group(function (){
    Route::get('/list', [LocationController::class,"list"])->name("list");
    Route::post('/create', [LocationController::class,"store"])->name("store");
});


