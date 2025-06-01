<?php

namespace App\Providers;

use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Contracts\ITopicRepository;
use App\Repositories\Contracts\IStudentRepository;
use App\Repositories\Contracts\ILecturerRepository;
use App\Repositories\Eloquent\TopicRepository;
use App\Repositories\Eloquent\StudentRepository;
use App\Repositories\Eloquent\LecturerRepository;
use App\Repositories\Contracts\IStatisticsRepository;
use App\Repositories\Eloquent\StatisticsRepository;
use App\Repositories\Contracts\IProjectRepository;
use App\Repositories\Eloquent\ProjectRepository;
use App\Repositories\Contracts\IProfileRepository;
use App\Repositories\Eloquent\ProfileRepository;
use App\Repositories\Contracts\IInternshipRepository;
use App\Repositories\Eloquent\InternshipRepository;
use App\Repositories\Contracts\IImportRepository;
use App\Repositories\Eloquent\ImportRepository;
use App\Repositories\Contracts\IHomeRepository;
use App\Repositories\Eloquent\HomeRepository;
use App\Repositories\Contracts\IFileUploadRepository;
use App\Repositories\Eloquent\FileUploadRepository;
use App\Repositories\Contracts\IDocumentRepository;
use App\Repositories\Eloquent\DocumentRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IUserRepository::class,UserRepository::class);
        $this->app->bind(ITopicRepository::class, TopicRepository::class);
        $this->app->bind(IStudentRepository::class, StudentRepository::class);
        $this->app->bind(ILecturerRepository::class, LecturerRepository::class);
        $this->app->bind(IStatisticsRepository::class, StatisticsRepository::class);
        $this->app->bind(IProjectRepository::class, ProjectRepository::class);
        $this->app->bind(IProfileRepository::class, ProfileRepository::class);
        $this->app->bind(IInternshipRepository::class, InternshipRepository::class);
        $this->app->bind(IImportRepository::class, ImportRepository::class);
        $this->app->bind(IHomeRepository::class, HomeRepository::class);
        $this->app->bind(IFileUploadRepository::class, FileUploadRepository::class);
        $this->app->bind(IDocumentRepository::class, DocumentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Paginator::useBootstrap();
    }
}
