<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TopicController;


Route::get('/', function () {
    return view('layouts.app');
});
Route::get('/topics/pending', [TopicController::class, 'pending'])->name('topics.pending');
Route::post('/topics/{topic}/approve', [TopicController::class, 'approve'])->name('topics.approve');
Route::post('/topics/{topic}/reject', [TopicController::class, 'reject'])->name('topics.reject');
Route::patch('/topics/{id}/{action}', [TopicController::class, 'changeStatus'])->name('topics.changeStatus');
Route::post('/topics/assign', [TopicController::class, 'assign'])->name('topics.assign');
Route::resource('projects', ProjectController::class);
Route::resource('topics', TopicController::class);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
use App\Http\Controllers\SinhVien;

Route::resource('students', SinhVien::class);
Route::get('students', [SinhVien::class, 'search'])->name('students.search');
Route::get('/students/create', [SinhVien::class, 'create'])->name('students.create');

use App\Http\Controllers\InternshipController;

Route::resource('internships', InternshipController::class);







