<?php

namespace Esanj\LayoutMaster\Providers;

use Illuminate\Support\ServiceProvider;

class LayoutMasterServiceProvider extends ServiceProvider
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
        $this->registerPublishing();
    }

    private function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->packagePath('resources/views') => resource_path('views'),
            ], 'esanj-layout-master-views');

            $this->publishes([
                $this->packagePath('resources/menu') => resource_path('menu'),
            ], 'esanj-layout-master-menu');

            $this->publishes([
                $this->packagePath('Components') => app_path('View/Components'),
            ], 'esanj-layout-master-components');
        }
    }

    private function packagePath(string $path): string
    {
        return dirname(__DIR__) . '/' . ltrim($path, '/');
    }
}
