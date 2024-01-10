<?php

use App\Http\Controllers\divesInscriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiveController;
use App\Http\Controllers\loginController;
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

Route::post("/diveslists",[divesInscriptionController::class,'registerDiverInTimeSlot'])->name('enterTimeSlot');

Route::post("/retire",[divesInscriptionController::class,'retireFromTimeSlot'])->name('leaveTimeSlot');

Route::get('/diveslists', [DiveController::class, 'index'])->name('viewDivesList');

Route::post('/', [loginController::class, 'Connection']);

Route::post('/disconnect', [loginController::class, 'Disconnection']);

Route::get('/diverlist/{div_id}',[DiveController::class,'diverList'])->name('diverlist');
Route::get('/test/{div_id}',[UserController::class,'getInscription']);

Route::get('/infoDive',[UserController::class],'getInscription');


Route::get('/infoDive',[UserController::class],'getInscription');


Route::get('/historique',[DiveController::class,'historique']);

Route::get('/users',[UserController::class,'getAllUsers'])->name('users');

Route::post('/update-role/{dvr_licence}', [UserController::class, 'updateRole'])->name('update-role');


Route::post('changeDataDives',[EditDiveParametersController::class,'changeDataDives']);
Route::get('/profile',[DiveController::class,'profile']);

//Route::view('/profile', 'profile');
