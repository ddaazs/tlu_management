<?php
require __DIR__.'/auth.php';
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\InternshipCompanyController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\InternshipController;
use Database\Seeders\TopicSeeder;


// Trang chủ
Route::get('/', fn() => redirect('home'));
Route::get('/home', fn() => view('page.home'))->middleware(['auth', 'verified'])->name('home');

//Route cho sinh vien
Route::middleware(['auth', 'can:sinhvien'])->group(function () {
    

    // Topics
    Route::get('/topics/register', [TopicController::class, 'register'])->name('topics.register');
    Route::post('/topics/register/{id}', [TopicController::class, 'register_1'])->name('topics.register.submit');
    Route::post('/topics/storeStudent', [TopicController::class, 'storeStudent'])->name('topics.storeStudent');
    Route::get('/topics/student', [TopicController::class, 'student'])->name('topics.student');
    Route::get('/topics', [TopicController::class, 'index'])->name('topics.index');
    Route::get('/topics/{id}', [TopicController::class, 'show'])->where('id', '[0-9]+')->name('topics.show');

    // Internships
    Route::get('/internships/student', [InternshipController::class, 'studentIndex'])->name('internships.studentIndex');
    Route::get('/internships/register', [InternshipController::class, 'studentCreate'])->name('internships.studentCreate');
    Route::post('/internships/register', [InternshipController::class, 'studentStore'])->name('internships.studentStore');
    Route::get('/internships', [InternshipController::class, 'index'])->name('internships.index');

    // Projects
    Route::get('/projects/student', [ProjectController::class, 'student'])->name('projects.student');
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');

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

    // Students resource
    Route::resource('students', StudentController::class);
    Route::get('/students/search', [StudentController::class, 'search'])->name('students.search');
});

// Route dành cho Admin (Quản trị viên)
Route::middleware(['auth', 'can:quantri'])->group(function () {


    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');

    Route::get('/import/lecturers', [ImportController::class, 'showLecturerImportForm'])->name('import.lecturers.form');
    Route::post('/import/lecturers', [ImportController::class, 'importLecturers'])->name('import.lecturers');

    // Quản lý chủ đề
    Route::get('/topics/pending', [TopicController::class, 'pending'])->name('topics.pending');
    Route::post('/topics/{topic}/approve', [TopicController::class, 'approve'])->name('topics.approve');
    Route::post('/topics/{topic}/reject', [TopicController::class, 'reject'])->name('topics.reject');
    Route::patch('/topics/{id}/{action}', [TopicController::class, 'changeStatus'])->name('topics.changeStatus');
    Route::post('/topics/assign', [TopicController::class, 'assign'])->name('topics.assign');

    Route::resources([
        'users'       => UserController::class,
        'lecturers'   => LecturerController::class,
        'internships' => InternshipController::class,
        'topics'      => TopicController::class,
        'statistics'  => StatisticsController::class,
        'projects'    => ProjectController::class,
        'documents'   => DocumentController::class,
        'students'    => StudentController::class
    ]);
    // Thống kê & Xuất báo cáo
    Route::prefix('statistics')->group(function () {
        // Xuất file Excel
        Route::get('/export/major', [StatisticsController::class, 'exportMajor'])->name('export.major');
        Route::get('/export/lecturer', [StatisticsController::class, 'exportLecturer'])->name('export.lecturer');
        Route::get('/export/score', [StatisticsController::class, 'exportScore'])->name('export.score');
        Route::get('/export/status', [StatisticsController::class, 'exportStatus'])->name('export.status');
        Route::get('/export/submission', [StatisticsController::class, 'exportSubmission'])->name('export.submission');
    
        // Xuất file PDF
        Route::get('/export/major-pdf', [StatisticsController::class, 'exportMajorPdf'])->name('export.major.pdf');
        Route::get('/export/lecturer-pdf', [StatisticsController::class, 'exportLecturerPdf'])->name('export.lecturer.pdf');
        Route::get('/export/score-pdf', [StatisticsController::class, 'exportScorePdf'])->name('export.score.pdf');
        Route::get('/export/status-pdf', [StatisticsController::class, 'exportStatusPdf'])->name('export.status.pdf');
        Route::get('/export/submission-pdf', [StatisticsController::class, 'exportSubmissionPdf'])->name('export.submission.pdf');
    
        // Xem file PDF
        Route::get('/view/major-pdf', [StatisticsController::class, 'viewMajorPdf'])->name('view.major.pdf');
        Route::get('/view/lecturer-pdf', [StatisticsController::class, 'viewLecturerPdf'])->name('view.lecturer.pdf');
        Route::get('/view/score-pdf', [StatisticsController::class, 'viewScorePdf'])->name('view.score.pdf');
        Route::get('/view/status-pdf', [StatisticsController::class, 'viewStatusPdf'])->name('view.status.pdf');
        Route::get('/view/submission-pdf', [StatisticsController::class, 'viewSubmissionPdf'])->name('view.submission.pdf');
    });
    

    // Download files
    Route::prefix('download')->group(function () {
        Route::get('/project/{id}', [FileUploadController::class, 'downloadProjectFile'])->name('project');
        Route::get('/internship/{id}', [FileUploadController::class, 'downloadInternshipFile'])->name('internship');
        Route::get('/documents/{id}', [DocumentController::class, 'download'])->name('documents');
    });

    // Quan sát đồ án & thực tập
    Route::get('/observe-projects', [FileUploadController::class, 'reviewProjects'])->name('observe.projects');
    Route::get('/observe-internships', [FileUploadController::class, 'reviewInternships'])->name('observe.internships');
});

// Route dành cho Giảng viên
Route::middleware(['auth', 'can:giangvien'])->group(function () {


    Route::get('students/search', [StudentController::class, 'search'])->name('students.search');
    
    // Quản lý chủ đề
    Route::get('/topics/pending', [TopicController::class, 'pending'])->name('topics.pending');
    Route::post('/topics/{topic}/approve', [TopicController::class, 'approve'])->name('topics.approve');
    Route::post('/topics/{topic}/reject', [TopicController::class, 'reject'])->name('topics.reject');
    Route::patch('/topics/{id}/{action}', [TopicController::class, 'changeStatus'])->name('topics.changeStatus');
    Route::post('/topics/assign', [TopicController::class, 'assign'])->name('topics.assign');
    
    Route::resources([
        'students'    => StudentController::class,
        'internships' => InternshipController::class,
        'topics'      => TopicController::class,
        'statistics'  => StatisticsController::class,
        'projects'    => ProjectController::class,
        'documents'   => DocumentController::class
    ]);

    // Xuất báo cáo
    Route::prefix('statistics')->group(function () {
        // Xuất file Excel
        Route::get('/export/major', [StatisticsController::class, 'exportMajor'])->name('export.major');
        Route::get('/export/lecturer', [StatisticsController::class, 'exportLecturer'])->name('export.lecturer');
        Route::get('/export/score', [StatisticsController::class, 'exportScore'])->name('export.score');
        Route::get('/export/status', [StatisticsController::class, 'exportStatus'])->name('export.status');
        Route::get('/export/submission', [StatisticsController::class, 'exportSubmission'])->name('export.submission');
    
        // Xuất file PDF
        Route::get('/export/major-pdf', [StatisticsController::class, 'exportMajorPdf'])->name('export.major.pdf');
        Route::get('/export/lecturer-pdf', [StatisticsController::class, 'exportLecturerPdf'])->name('export.lecturer.pdf');
        Route::get('/export/score-pdf', [StatisticsController::class, 'exportScorePdf'])->name('export.score.pdf');
        Route::get('/export/status-pdf', [StatisticsController::class, 'exportStatusPdf'])->name('export.status.pdf');
        Route::get('/export/submission-pdf', [StatisticsController::class, 'exportSubmissionPdf'])->name('export.submission.pdf');
    
        // Xem file PDF
        Route::get('/view/major-pdf', [StatisticsController::class, 'viewMajorPdf'])->name('view.major.pdf');
        Route::get('/view/lecturer-pdf', [StatisticsController::class, 'viewLecturerPdf'])->name('view.lecturer.pdf');
        Route::get('/view/score-pdf', [StatisticsController::class, 'viewScorePdf'])->name('view.score.pdf');
        Route::get('/view/status-pdf', [StatisticsController::class, 'viewStatusPdf'])->name('view.status.pdf');
        Route::get('/view/submission-pdf', [StatisticsController::class, 'viewSubmissionPdf'])->name('view.submission.pdf');
    });
    

    // Download files
    Route::get('documents/{id}/download', [DocumentController::class, 'download'])->name('documents.download');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});






