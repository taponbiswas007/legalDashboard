<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Subscriber;
use App\Models\JobApplication;

class LayoutDataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $view->with('subscribers', Subscriber::orderBy('created_at', 'desc')->get());
            $view->with('jobApplications', JobApplication::with('job')->orderBy('created_at', 'desc')->get());
            $view->with('messages', \App\Models\Contact::orderBy('created_at', 'desc')->get());
        });
    }
}
