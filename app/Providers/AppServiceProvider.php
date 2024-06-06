<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Teacher\TeacherRepository;
use App\Repositories\Teacher\TeacherRepositoryInterface;
use App\Repositories\Classroom\ClassroomRepositoryInterface;
use App\Repositories\Classroom\ClassroomRepository;
use App\Repositories\Classroom\WeekTableRepository;
use App\Repositories\Department\DepartmentRepositoryInterface;
use App\Repositories\Department\DepartmentRepository;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\WeekTable\WeekTableRepositoryInterface ;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       
        $this->app->bind(ClassroomRepositoryInterface::class,ClassroomRepository::class);
        $this->app->bind(TeacherRepositoryInterface::class,TeacherRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class,DepartmentRepository::class);
        $this->app->bind(SubjectRepositoryInterface::class,SubjectRepository::class);
        $this->app->bind(WeekTableRepositoryInterface::class,WeekTableRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
