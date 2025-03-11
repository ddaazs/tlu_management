<?php

use App\Http\Controllers\LecturerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatisticsController;

Route::get('/', function (){
    return redirect('home');
});

// Route::resource('users', UserController::class);
// Route::resource('lecturers', LecturerController::class);

Route::get('/home', function () {
    return view('page.home');
})->middleware(['auth', 'verified'])->name('home');

// Route::resource('users', UserController::class);
// Route::resource('lecturers', LecturerController::class);

Route::get('/home', function () {
    return view('page.home');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware(['auth', 'can:quantri'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('lecturers', LecturerController::class);
});
Route::get('/statistics', [StatisticsController::class, 'index'])
    ->name('statistics.index');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
