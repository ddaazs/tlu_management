<?php

use App\Http\Controllers\LecturerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
    return redirect('home');
});

// Route::resource('users', UserController::class);
// Route::resource('lecturers', LecturerController::class);

Route::get('/home', function () {
    return view('page.home');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware(['auth', 'can:quantri'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('lecturers', LecturerController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
