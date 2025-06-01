<?php

namespace App\Providers;

use App\Repositories\Contracts\IUserRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Contracts\ITopicRepository;
use App\Repositories\Contracts\IStudentRepository;
use App\Repositories\Contracts\ILecturerRepository;
use App\Repositories\Eloquent\TopicRepository;
use App\Repositories\Eloquent\StudentRepository;
use App\Repositories\Eloquent\LectureRepository;
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
        $this->app->bind(ILecturerRepository::class, LectureRepository::class);
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
