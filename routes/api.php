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


    Route::post('/user-login', [LoginController::class, 'login'])->name('users.login');
    Route::post('/user-register', [LoginController::class, 'register'])->name('users.register');

    Route::middleware('auth:api')->group(function () {

        Route::get('/users/show', [LoginController::class, 'getAllUsers'])->name('users.getAllUsers');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    });


    Route::post('/forgot-password', [LoginController::class, 'sendForgetPasswordEmail'])->name('forgot-password.send');
Route::post('/verify-password-reset', [LoginController::class, 'verifyForgetPassword'])->name('forgot-password.verify');

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




