<?php

use App\Http\Controllers\divesInscriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiveController;
use App\Http\Controllers\EditDiveParametersController;
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
})->name('welcome');

//Route::get('diveslists', [DiveController::class, 'index']);

Route::get('diveParameters', [EditDiveParametersController::class, 'index']);

Route::post("/diveslists/{selectedDive}",[divesInscriptionController::class,'registerDiverInTimeSlot'])->name('enterTimeSlot');

Route::post("/retire/{selectedDive}",[divesInscriptionController::class,'retireFromTimeSlot'])->name('leaveTimeSlot');

Route::get('/diveslists', [DiveController::class, 'index'])->name('viewDivesList');

Route::post('/', [App\Http\Controllers\loginController::class, 'Connection']);

Route::post('/disconnect', [App\Http\Controllers\loginController::class, 'Disconnection']);

Route::get('/diverlist',[DiveController::class,'diverList']);

Route::get('/profile',[DiveController::class,'profile']);

//Route::view('/profile', 'profile');

Route::get('/addDiver', [divesInscriptionController::class,'checkDivesDirector']);