<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\ApiCoachController;
use App\Http\Controllers\Api\Auth\ApiProgramController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/user-login', [LoginController::class, 'login'])->name('loginAPI');
Route::post('/user-store', [LoginController::class, 'store'])->name('store');

Route::middleware('auth:api')->group(function () {
    Route::get('/user-show', [LoginController::class, 'show'])->name('show');
    Route::post('/user-logout', [LoginController::class, 'destroy'])->name('destroy');


  


});

// CoachApi's
Route::get('/get-all-coachs', [ApiCoachController ::class, 'getAllCoachs'])->name('getAllCoachs');
Route::post('/coach-store', [ApiCoachController ::class, 'storeNewCoach'])->name('storeNewCoach');
Route::get('/show-coach/{id}', [ApiCoachController ::class, 'showCoach'])->name('showCoach');
Route::get('/edit-coach/{id}', [ApiCoachController ::class, 'editCoachData'])->name('editCoachData');
Route::put('/update-coach/{id}', [ApiCoachController ::class, 'updateCoachData'])->name('updateCoachData');
Route::delete('/delete-coach/{id}', [ApiCoachController ::class, 'destroyCoach'])->name('destroyCoach');

// ProgramApi's
Route::get('/get-all-Programs', [ApiProgramController ::class, 'getAllPrograms'])->name('getAllPrograms');
Route::post('/program-store', [ApiProgramController ::class, 'storeNewProgram'])->name('storeNewProgram');
Route::get('/show-program/{id}', [ApiProgramController ::class, 'showProgram'])->name('showProgram');
Route::get('/edit-program/{id}', [ApiProgramController ::class, 'editProgramData'])->name('editProgramData');
Route::put('/update-program/{id}', [ApiProgramController ::class, 'updateProgramData'])->name('updateProgramData');
Route::delete('/delete-program/{id}', [ApiProgramController ::class, 'destroyProgram'])->name('destroyProgram');



// Route::get('/customers/get-all', [CustomerController::class, 'index'])->name('index');
// Route::post('/customers/store', [CustomerController::class, 'store'])->name('store');
// Route::get('/customer/{id}', [CustomerController::class, 'show'])->name('show');
// Route::get('/customer/{id}/edit', [CustomerController::class, 'edit'])->name('edit');
// Route::put('/customer/{id}/update', [CustomerController::class, 'update'])->name('update');
// Route::delete('/customer/{id}/delete', [CustomerController::class, 'destroy'])->name('delete');

