<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\coach\CoachController;
use App\Http\Controllers\user\UserController;

use App\Http\Controllers\AdminDashboard\GymProgramController;
use App\Http\Controllers\AdminDashboard\GymCoachController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminDashboard\TagController;
use App\Http\Controllers\AdminDashboard\ExercisesController;
use App\Http\Controllers\AdminDashboard\FormController;
use App\Http\Controllers\AdminDashboard\GymClientController;
use App\Http\Controllers\AdminDashboard\WorkoutController;
use App\Http\Controllers\AdminDashboard\GymSetController;





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






Route::get('/', function () {
    return view('auth/register');
});



Route::get('/get-dashboard', function () {
    return view('master.layouts.app');
    // return 'working';
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



// admin;
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function(){
    Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::post('logout', [AdminController::class, 'destroy'])->name('logout');
    
    
});


//coach;
Route::prefix('coach')->name('coach.')->middleware(['auth', 'role:coach'])->group(function(){
    Route::get('dashboard', [CoachController::class, 'index'])->name('dashboard');
    Route::post('logout', [CoachController::class, 'destroy'])->name('logout');

});


//user;
Route::prefix('user')->name('user.')->middleware(['auth', 'role:user'])->group(function(){
    Route::get('dashboard', [UserController::class, 'index'])->name('dashboard');
    Route::post('logout', [CoachController::class, 'destroy'])->name('logout');

});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::post('logout', [AdminController::class, 'destroy'])->name('logout');
    
    
});


Route::get('/chat-index', [ChatController::class, 'index'])->name('chat.index');
Route::get('/chat-user', [ChatController::class, 'userChat'])->name('chat.user');

Route::resource('roles', RoleController::class);


// Route GymCoachController 
Route::get('/coachs',[GymCoachController::class,'index'])->name('coachs.index');
Route::get('/coachs/create',[GymCoachController::class,'create'])->name('coachs.create');
Route::post('/coachs/store',[GymCoachController::class,'store'])->name('coachs.store');
Route::get('/coachs/show/{id}',[GymCoachController::class,'show'])->name('coachs.show');
Route::get('/coachs/edit/{id}',[GymCoachController::class,'edit'])->name('coachs.edit');
Route::put('/coachs/update/{id}',[GymCoachController::class,'update'])->name('coachs.update');
Route::post('/coachs/delete/{id}',[GymCoachController::class,'destroy'])->name('coachs.destroy');

// Route GymClientController 
Route::get('/user',[GymClientController::class,'index'])->name('user.index');
Route::get('/user/create',[GymClientController::class,'create'])->name('user.create');
Route::post('/user/store',[GymClientController::class,'store'])->name('user.store');
Route::get('/user/show/{id}',[GymClientController::class,'show'])->name('user.show');
Route::get('/user/edit/{id}',[GymClientController::class,'edit'])->name('user.edit');
Route::put('/user/update/{id}',[GymClientController::class,'update'])->name('user.update');
Route::post('/user/delete/{id}',[GymClientController::class,'destroy'])->name('user.destroy');


// Route Tags Controllers
Route::get('tags', [TagController::class, 'index'])->name('tags.index');
Route::get('tags/create', [TagController::class, 'create'])->name('tags.create');
Route::post('tags', [TagController::class, 'store'])->name('tags.store');
Route::get('tags/{tag}', [TagController::class, 'show'])->name('tags.show');
Route::get('tags/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');
Route::put('tags/{tag}', [TagController::class, 'update'])->name('tags.update');
Route::delete('tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');


// Route GymProgramController Controllers
Route::get('/program',[GymProgramController::class,'index'])->name('program.index');
Route::get('/program/create',[GymProgramController::class,'create'])->name('program.create');
Route::post('/program/store',[GymProgramController::class,'store'])->name('program.store');
Route::get('/program/show/{id}',[GymProgramController::class,'show'])->name('program.show');
Route::get('/program/edit/{id}',[GymProgramController::class,'edit'])->name('program.edit');
Route::put('/program/update/{id}',[GymProgramController::class,'update'])->name('program.update');
Route::get('/program/{id}', [GymProgramController::class, 'destroy'])->name('program.destroy');


// Route ExercisesController Controllers
Route::get('exercises', [ExercisesController::class, 'index'])->name('exercises.index');
Route::get('exercises/create', [ExercisesController::class, 'create'])->name('exercises.create');
Route::post('exercises', [ExercisesController::class, 'store'])->name('exercises.store');
Route::get('exercises/{exercises}', [ExercisesController::class, 'show'])->name('exercises.show');
Route::get('exercises/{exercises}/edit', [ExercisesController::class, 'edit'])->name('exercises.edit');
Route::put('exercises/{exercises}', [ExercisesController::class, 'update'])->name('exercises.update');
Route::delete('exercises/{exercises}', [ExercisesController::class, 'destroy'])->name('exercises.destroy');


// Route ExercisesController Controllers
Route::get('workout', [WorkoutController::class, 'index'])->name('workout.index');
Route::get('workout/create', [WorkoutController::class, 'create'])->name('workout.create');
Route::post('workout', [WorkoutController::class, 'store'])->name('workout.store');
Route::get('workout/{workout}', [WorkoutController::class, 'show'])->name('workout.show');
Route::get('workout/{workout}/edit', [WorkoutController::class, 'edit'])->name('workout.edit');
Route::put('workout/{workout}', [WorkoutController::class, 'update'])->name('workout.update');
Route::post('workout/{workout}', [WorkoutController::class, 'destroy'])->name('workout.destroy');

// Route ExercisesController Controllers

Route::get('/set',[GymSetController::class,'index'])->name('set.index');
Route::get('/set/create',[GymSetController::class,'create'])->name('set.create');
Route::post('/set/store',[GymSetController::class,'store'])->name('set.store');
Route::get('/set/show/{id}',[GymSetController::class,'show'])->name('set.show');
Route::get('/set/edit/{id}',[GymSetController::class,'edit'])->name('set.edit');
Route::put('/set/update/{id}',[GymSetController::class,'update'])->name('set.update');
Route::post('/set/delete/{id}',[GymSetController::class,'destroy'])->name('set.destroy');



Route::get('form/index', [FormController::class, 'index'])->name('form.index');
Route::get('form/create', [FormController::class, 'create'])->name('form.create');
Route::post('form/store', [FormController::class, 'store'])->name('form.store');

Route::get('form/edit/{id}', [FormController::class, 'edit'])->name('form.edit');
Route::get('form/destroy/{id}', [FormController::class, 'destroy'])->name('form.destroy');


Route::get('new/form', function (){
    return view('form.new_form');
});






