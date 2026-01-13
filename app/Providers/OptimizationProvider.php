<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OptimizationProvider extends ServiceProvider
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
        // Disable lazy loading for better performance awareness
        Model::preventLazyLoading(!$this->isProduction());

        // Enable query logging only in non-production
        if (!$this->isProduction()) {
            DB::listen(function ($query) {
                // Log slow queries (> 1 second)
                if ($query->time > 1000) {
                    Log::warning('Slow Query Detected', [
                        'query' => $query->sql,
                        'bindings' => $query->bindings,
                        'time' => $query->time . 'ms',
                    ]);
                }
            });
        }

        // Optimize Eloquent queries
        $this->optimizeQueries();

        // Enable query caching for frequently accessed data
        $this->enableCaching();
    }

    /**
     * Optimize Eloquent query behavior
     */
    private function optimizeQueries(): void
    {
        // Eager load relations by default
        Model::preventLazyLoading(!$this->isProduction());

        // Set default pagination
        \Illuminate\Pagination\Paginator::useBootstrap();
    }

    /**
     * Enable caching for frequently accessed models
     */
    private function enableCaching(): void
    {
        // Cache will be applied in repositories/models
    }

    /**
     * Check if application is in production environment
     */
    private function isProduction(): bool
    {
        return $this->app->environment('production');
    }
}
