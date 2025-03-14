<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // Định nghĩa policy tại đây (nếu có)
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        // Định nghĩa quyền admin
        Gate::define('quantri', function ($user) {
            return $user->role === 'quantri';
        });
        // Định nghĩa quyền giảng viên
        Gate::define('giangvien', function ($user) {
            return $user->role === 'giangvien';
        });

        // Định nghĩa quyền sinh viên
        Gate::define('sinhvien', function ($user) {
            return $user->role === 'sinhvien';
        });
    }
}
