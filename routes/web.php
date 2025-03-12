<?php

use App\Http\Controllers\ImportController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\FileUploadController;

Route::middleware(['auth'])->group(function () {
    Route::get('/file-upload', [FileUploadController::class, 'index'])->name('file-upload');

    Route::get('/file-upload/project/{id}/edit', [FileUploadController::class, 'editProject'])->name('edit.project');
    Route::post('/file-upload/project/{id}', [FileUploadController::class, 'storeProject'])->name('store.project');

    Route::get('/file-upload/internship/{id}/edit', [FileUploadController::class, 'editInternship'])->name('edit.internship');
    Route::post('/file-upload/internship/{id}', [FileUploadController::class, 'storeInternship'])->name('store.internship');
    // Danh sách đồ án với phân trang
    Route::get('/observe-projects', [FileUploadController::class, 'reviewProjects'])->name('observe.projects');
    // Danh sách báo cáo thực tập với phân trang
    Route::get('/observe-internships', [FileUploadController::class, 'reviewInternships'])->name('observe.internships');
    Route::get('/download/project/{id}', [FileUploadController::class, 'downloadProjectFile'])->name('download.project');
    Route::get('/download/internship/{id}', [FileUploadController::class, 'downloadInternshipFile'])->name('download.internship');
});




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
    Route::get('/import/lecturers', [ImportController::class, 'showLecturerImportForm'])->name('import.lecturers.form');
    Route::post('/import/lecturers', [ImportController::class, 'importLecturers'])->name('import.lecturers');
});
Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');

// Xuất báo cáo cho từng thống kê
Route::get('/statistics/export/major', [StatisticsController::class, 'exportMajor'])->name('export.major');
Route::get('/statistics/export/lecturer', [StatisticsController::class, 'exportLecturer'])->name('export.lecturer');
Route::get('/statistics/export/score', [StatisticsController::class, 'exportScore'])->name('export.score');
Route::get('/statistics/export/status', [StatisticsController::class, 'exportStatus'])->name('export.status');
Route::get('/statistics/export/submission', [StatisticsController::class, 'exportSubmission'])->name('export.submission');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
// Trang giao diện upload file của sinh viên


require __DIR__.'/auth.php';
