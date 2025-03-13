<?php

use App\Http\Controllers\ImportController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TopicController;

use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\DocumentController;

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
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');

// Route để hiển thị form upload tài liệu
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{id}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::get('/edit/{id}', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::post('/update/{id}', [DocumentController::class, 'update'])->name('documents.update');
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
Route::get('/topics/pending', [TopicController::class, 'pending'])->name('topics.pending');
Route::post('/topics/{topic}/approve', [TopicController::class, 'approve'])->name('topics.approve');
Route::post('/topics/{topic}/reject', [TopicController::class, 'reject'])->name('topics.reject');
Route::patch('/topics/{id}/{action}', [TopicController::class, 'changeStatus'])->name('topics.changeStatus');
Route::post('/topics/assign', [TopicController::class, 'assign'])->name('topics.assign');
Route::resource('projects', ProjectController::class);
Route::resource('topics', TopicController::class);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

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







