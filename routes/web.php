<?php
use App\Http\Controllers\ImportController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect('home'));
Route::get('/home', fn() => view('page.home'))->middleware(['auth', 'verified'])->name('home');

Route::middleware(['auth', 'can:sinhvien'])->group(function () {
    Route::get('/topics/register', [TopicController::class, 'register'])->name('topics.register');
    Route::post('/topics/register/{id}', [TopicController::class, 'register_1'])->name('topics.register.submit');
    Route::post('/topics/storeStudent', [TopicController::class, 'storeStudent'])->name('topics.storeStudent');

    Route::prefix('internships')->group(function () {
        Route::get('/student', [InternshipController::class, 'studentIndex'])->name('internships.studentIndex');
        Route::get('/register', [InternshipController::class, 'studentCreate'])->name('internships.studentCreate');
        Route::post('/register', [InternshipController::class, 'studentStore'])->name('internships.studentStore');
    });
    
    Route::resource('students', StudentController::class);
    Route::get('/students/search', [StudentController::class, 'search'])->name('students.search');
}); 
// Route chung cho tất cả vai trò
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // File Upload
    Route::get('/file-upload', [FileUploadController::class, 'index'])->name('file-upload');
    Route::get('/file-upload/project/{id}/edit', [FileUploadController::class, 'editProject'])->name('edit.project');
    Route::post('/file-upload/project/{id}', [FileUploadController::class, 'storeProject'])->name('store.project');

    // Documents
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{id}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::get('/documents/{id}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::put('/documents/{id}', [DocumentController::class, 'update'])->name('documents.update');

    // Projects
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/student', [ProjectController::class, 'student'])->name('projects.student');

    // Internships
    Route::get('/internships', [InternshipController::class, 'index'])->name('internships.index');
    Route::get('/internships/student', [InternshipController::class, 'studentIndex'])->name('internships.studentIndex');
    Route::get('/internships/create', [InternshipController::class, 'create'])->name('internships.create'); // Thêm lại route thiếu
    Route::post('/internships', [InternshipController::class, 'store'])->name('internships.store');
    Route::get('/internships/{internship}/edit', [InternshipController::class, 'edit'])->name('internships.edit');
    Route::put('/internships/{internship}', [InternshipController::class, 'update'])->name('internships.update');
    Route::delete('/internships/{internship}', [InternshipController::class, 'destroy'])->name('internships.destroy');
    Route::get('/internships/{internship}', [InternshipController::class, 'show'])->name('internships.show');
});

// Route dành riêng cho Quản trị viên
Route::middleware(['auth', 'can:quantri'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('lecturers', LecturerController::class);
    Route::get('/import/lecturers', [ImportController::class, 'showLecturerImportForm'])->name('import.lecturers.form');
    Route::post('/import/lecturers', [ImportController::class, 'importLecturers'])->name('import.lecturers');

    Route::post('/topics/{topic}/approve', [TopicController::class, 'approve'])->name('topics.approve');
    Route::post('/topics/{topic}/reject', [TopicController::class, 'reject'])->name('topics.reject');
    Route::post('/topics/{id}/{action}', [TopicController::class, 'changeStatus'])->name('topics.changeStatus');
    Route::get('/topics/{id}/details', fn($id) => response()->json(\App\Models\Topic::with(['lecturer', 'student'])->findOrFail($id)));
    Route::post('/topics/assign', [TopicController::class, 'assign'])->name('topics.assign');
});

// Route dùng chung cho Quản trị viên và Giảng viên
Route::middleware(['auth', 'can:quantri,giangvien'])->group(function () {
    Route::get('/topics/create', [TopicController::class, 'create'])->name('topics.create');
    Route::post('/topics', [TopicController::class, 'store'])->name('topics.store');
    Route::get('/topics/{id}/edit', [TopicController::class, 'edit'])->name('topics.edit');
    Route::put('/topics/{id}', [TopicController::class, 'update'])->name('topics.update');
    Route::delete('/topics/{id}', [TopicController::class, 'destroy'])->name('topics.destroy');
    Route::get('/topics/pending', [TopicController::class, 'pending'])->name('topics.pending');
});

// Route dành riêng cho Sinh viên


// Route không giới hạn (có thể cần thêm middleware)
Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
Route::get('/statistics/export/major', [StatisticsController::class, 'exportMajor'])->name('export.major');
Route::get('/statistics/export/lecturer', [StatisticsController::class, 'exportLecturer'])->name('export.lecturer');
Route::get('/statistics/export/score', [StatisticsController::class, 'exportScore'])->name('export.score');
Route::get('/statistics/export/status', [StatisticsController::class, 'exportStatus'])->name('export.status');
Route::get('/statistics/export/submission', [StatisticsController::class, 'exportSubmission'])->name('export.submission');

Route::get('/topics', [TopicController::class, 'index'])->name('topics.index');
Route::get('/topics/student', [TopicController::class, 'student'])->name('topics.student');
Route::get('/topics/{id}', [TopicController::class, 'show'])->where('id', '[0-9]+')->name('topics.show');

require __DIR__.'/auth.php';