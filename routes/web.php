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
    Route::post('/create', [LocationController::class,"store"])->name("store")->middleware('throttle:10,1');
    Route::get('/{id}', [LocationController::class,"show"])->name("show");
    Route::put('/update', [LocationController::class,"update"])->name("update")->middleware('throttle:10,1');
    Route::delete('/delete', [LocationController::class,"delete"])->name("delete")->middleware('throttle:10,1');
});


