<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\coach\CoachController;
use App\Http\Controllers\user\UserController;

use App\Http\Controllers\GymProgramController;
use App\Http\Controllers\GymCoachController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TagController;




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




//Routes Coachs

Route::get('/coachs',[GymCoachController::class,'index']);
Route::get('/coachs/create',[GymCoachController::class,'create']);
Route::post('/coachs/store',[GymCoachController::class,'store']);
Route::get('/coachs/view/{id}',[GymCoachController::class,'show']);
Route::get('/coachs/edit/{id}',[GymCoachController::class,'edit']);
Route::put('/coachs/update/{id}',[GymCoachController::class,'update']);
Route::get('/coachs/delete/{id}',[GymCoachController::class,'destroy']);

//


Route::resource('roles', RoleController::class);
// Route::resource('tags', TagController::class);
Route::resource('programs', GymProgramController::class);

// Route Tags Controllers
// Index
Route::get('tags', [TagController::class, 'index'])->name('tags.index');

// Create
Route::get('tags/create', [TagController::class, 'create'])->name('tags.create');
Route::post('tags', [TagController::class, 'store'])->name('tags.store');

// Show
Route::get('tags/{tag}', [TagController::class, 'show'])->name('tags.show');

// Edit
Route::get('tags/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');
Route::put('tags/{tag}', [TagController::class, 'update'])->name('tags.update');

// Delete
Route::delete('tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');

