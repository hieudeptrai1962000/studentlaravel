<?php

namespace App\Providers;


use App\Repositories\Faculty\FacultyRepository;
use App\Repositories\Faculty\FacultyRepositoryInterface;
use App\Repositories\Student\StudentRepository;
use App\Repositories\Student\StudentRepositoryInterface;
use App\Repositories\Studentsubject\StudentsubjectRepository;
use App\Repositories\Studentsubject\StudentsubjectRepositoryInterface;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\Users\UsersRepository;
use App\Repositories\Users\UsersRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FacultyRepositoryInterface::class,FacultyRepository::class);
        $this->app->singleton(StudentRepositoryInterface::class,StudentRepository::class);
        $this->app->singleton(SubjectRepositoryInterface::class,SubjectRepository::class);
        $this->app->singleton(StudentsubjectRepositoryInterface::class,StudentsubjectRepository::class);
        $this->app->singleton(UsersRepositoryInterface::class,UsersRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
