<?php

use App\Http\Controllers\Api\Auth\ApiClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\MessageController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\ApiCoachController;
use App\Http\Controllers\Api\Auth\ApiProgramController;
use App\Http\Controllers\Api\Auth\ApiTagController;

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
Route::post('/edit-coach/{id}', [ApiCoachController ::class, 'editCoachData'])->name('editCoachData');
Route::post('/update-coach/{id}', [ApiCoachController ::class, 'updateCoachData'])->name('updateCoachData');
Route::post('/delete-coach/{id}', [ApiCoachController ::class, 'destroyCoach'])->name('destroyCoach');

// ProgramApi's
Route::get('/get-all-Programs', [ApiProgramController ::class, 'getAllPrograms'])->name('getAllPrograms');
Route::post('/program-store', [ApiProgramController ::class, 'storeNewProgram'])->name('storeNewProgram');
Route::get('/show-program/{id}', [ApiProgramController ::class, 'showProgram'])->name('showProgram');
Route::get('/edit-program/{id}', [ApiProgramController ::class, 'editProgramData'])->name('editProgramData');
Route::post('/update-program/{id}', [ApiProgramController ::class, 'updateProgramData'])->name('updateProgramData');
Route::post('/delete-program/{id}', [ApiProgramController ::class, 'destroyProgram'])->name('destroyProgram');

Route::get('/get-user-id/{id}', [ApiClientController ::class, 'get_user_id'])->name('get_user_id');
Route::post('/edit-user-id/{id}', [ApiClientController ::class, 'edit_user_id'])->name('edit_user_id');

Route::get('/get-all-tags', [ApiTagController::class, 'get_all_tags'])->name('get_all_tags');
Route::get('/get-tag-id/{id}', [ApiTagController ::class, 'get_tag_id'])->name('get_tag_id');
Route::post('/store-tags', [ApiTagController ::class, 'store_tags'])->name('store_tags');
Route::post('/edit-tags', [ApiTagController ::class, 'edit_tags'])->name('edit_tags');
Route::post('/delete-tags', [ApiTagController ::class, 'delete_tags'])->name('delete_tags');

Route::post('/send-chat/{id}',[MessageController::class,'sendMessage']);
Route::post('/get-chat/{receiverId}/{sender_Id}',[MessageController::class,'getMessages']);
Route::get('/getChats/{id}/{program_id}',[MessageController::class,'getChats']);