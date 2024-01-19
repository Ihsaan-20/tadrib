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

use App\Http\Controllers\Api\Auth\ApiExerciseControleler;
use App\Http\Controllers\Api\Auth\ApiSetController;
use App\Http\Controllers\Api\Auth\ApiWorkoutController;
use App\Http\Controllers\Api\Auth\GroupChatController;


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

//get-coach  programs
Route::get('/get-coach/{coach_id}/programs/', [ApiCoachController ::class, 'getCoachPrograms'])->name('getCoachPrograms');


// Exercixe api;
Route::get('/get-all-exercises', [ApiExerciseControleler ::class, 'getAllExercises'])->name('getAllExercises');
Route::post('/store-exercise', [ApiExerciseControleler ::class, 'storeExercise'])->name('storeNewExercise');
Route::get('/edit-exercise/{id}', [ApiExerciseControleler ::class, 'editExercise'])->name('editExercise');
Route::post('/update-exercise/{id}', [ApiExerciseControleler ::class, 'updateExercise'])->name('updateExercise');
Route::get('/show-exercise/{id}', [ApiExerciseControleler ::class, 'showExercise'])->name('showExercise');
Route::post('/delete-exercise/{id}', [ApiExerciseControleler ::class, 'destroyExercise'])->name('destroyExercise');
// Set api;
Route::get('/get-all-sets', [ApiSetController ::class, 'getAllSets'])->name('getAllSets');
Route::post('/store-set', [ApiSetController ::class, 'storeSet'])->name('storeNewSet');
Route::get('/edit-set/{id}', [ApiSetController ::class, 'editSet'])->name('editSet');
Route::post('/update-set/{id}', [ApiSetController ::class, 'updateSet'])->name('updateSet');
Route::get('/show-set/{id}', [ApiSetController ::class, 'showSet'])->name('showSet');
Route::post('/delete-set/{id}', [ApiSetController ::class, 'destroySet'])->name('destroySet');
// Workout api;
Route::get('/get-all-workouts', [ApiWorkoutController ::class, 'getAllWorkout'])->name('getAllWorkout');
Route::post('/store-workout', [ApiWorkoutController ::class, 'storeWorkout'])->name('storeNewWorkout');
Route::get('/edit-workout/{id}', [ApiWorkoutController ::class, 'editWorkout'])->name('editWorkout');
Route::post('/update-workout/{id}', [ApiWorkoutController ::class, 'updateWorkout'])->name('updateWorkout');
Route::get('/show-workout/{id}', [ApiWorkoutController ::class, 'showWorkout'])->name('showWorkout');
Route::post('/delete-workout/{id}', [ApiWorkoutController ::class, 'destroyWorkout'])->name('destroyWorkout');


//group chat apis

Route::post('create-group/{id}',[GroupChatController::class,'create_group']);
Route::post('send-group-chat/{id}/{group_id}',[GroupChatController::class,'send_group_chat']);
Route::get('get-all-coach-groups/{id}',[GroupChatController::class,'get_all_coach_groups']);
Route::get('get-all-user-groups/{id}',[GroupChatController::class,'get_all_user_groups']);
Route::get('group-chat-by-id/{id}/{group_id}',[GroupChatController::class,'group_chat_by_id']);
Route::post('edit-group/{group_id}',[GroupChatController::class,'edit_group']);
Route::post('delete-group/{group_id}',[GroupChatController::class,'delete_group']);