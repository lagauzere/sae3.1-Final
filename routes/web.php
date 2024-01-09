<?php

use App\Http\Controllers\divesInscriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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


Route::post("/joinTimeSlot/{selectedDive}",[divesInscriptionController::class,'registerDiverInTimeSlot'])->name('enterTimeSlot');


Route::get('diveslists', [DiveController::class, 'index']);
