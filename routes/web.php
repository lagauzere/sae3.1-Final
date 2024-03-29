<?php

use App\Http\Controllers\divesInscriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DirectorController;
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

Route::get('diveParameters/{div_id}', [EditDiveParametersController::class, 'index']);

Route::post("/diveslists",[divesInscriptionController::class,'registerDiverInTimeSlot'])->name('enterTimeSlot');

Route::post("/retire",[divesInscriptionController::class,'retireFromTimeSlot'])->name('leaveTimeSlot');

Route::get('/directedplanneddiveslist', [DirectorController::class, 'directedPlannedDiveList']);

Route::get('/diveslists', [DiveController::class, 'index'])->name('viewDivesList');

Route::post('/', [loginController::class, 'Connection']);

Route::post('/disconnect', [loginController::class, 'Disconnection']);

Route::get('/diverlist/{div_id}',[DiveController::class,'diverList'])->name('diverlist');


Route::get('creationDive', [DiveController::class,'creationDive']);
Route::post('createDataDives', [DiveController::class, 'creationDataDives'])->name('createDataDive');

Route::get('/profile',[DiveController::class,'profile']);

Route::post('/changeDataDives',[EditDiveParametersController::class,'changeDataDives']);

Route::post('/directorDive', [DirectorController::class,'editDivers'])->name('edit-dive');

Route::post('/handle-form-change-participation-state', [DirectorController::class,'handleFormChangeParticipationStateSubmission'])->name('handle-form-change-participation-state');

Route::post('/directedplanneddiveslist', [DirectorController::class,'deleteDiver'])->name('handle-form-delete');

Route::get('/search-people', [UserController::class,'searchPeople']);
Route::get('/search-people-for-dive', [UserController::class,'searchPeopleNotInDive']);

Route::post('/handle-form-add-participation', [DirectorController::class,'handleFormAddParticipationSubmission'])->name('handle-form-add-participation');

Route::post('/handle-form-remove-participation', [DirectorController::class,'handleFormRemoveParticipationSubmission'])->name('handle-form-remove-participation');

Route::get('/infoDive',[UserController::class],'getInscription');

Route::get('/historique',[DiveController::class,'historique']);

Route::get('/users',[UserController::class,'getAllUsers'])->name('users');

Route::post('/update-role/{dvr_licence}', [UserController::class, 'updateRole'])->name('update-role');

Route::view('/changePwd','changePwd')->name('changePwd');

Route::post('/changePwd',[UserController::class,'updatePassword']);
Route::get('/info/{div_id}',[DiveController::class,'getInfos'])->name('info');

//Route::view('/profile', 'profile');

