<?php

namespace App\Providers;

use App\Contracts\Interfaces\StudentInterface;
use App\Contracts\Interfaces\TeacherInterface;
use App\Contracts\Repositories\StudentRepository;
use App\Contracts\Repositories\TeacherRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(StudentInterface::class, StudentRepository::class);
        $this->app->bind(TeacherInterface::class, TeacherRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
