<?php

namespace App\Providers;

use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\Page;
use App\Models\Student;
use App\Observers\JobApplicationObserver;
use App\Observers\StudentObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Paginator::useBootstrap();

        View::composer('*', function ($view)
        {
            $categories = JobCategory::where('status', 1)
                ->orderBy('name')
                ->get();

            $view->with('categories', $categories);
        });

        View::composer('*', function ($view)
        {
            $footerPages = Page::where('status', 1)
                ->whereIn('slug', ['terms-and-conditions', 'privacy-policy'])
                ->get();

            $view->with('footerPages', $footerPages);
        });

        Student::observe(StudentObserver::class);
        JobApplication::observe(JobApplicationObserver::class);

    }
}
