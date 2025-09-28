<?php

namespace Esanj\LayoutMaster\Providers;

use Esanj\LayoutMaster\Commands\InstallCommand;
use Illuminate\Support\ServiceProvider;

class LayoutMasterServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerCommands();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPublishing();
    }

    private function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
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
                $this->packagePath('resources/assets') => resource_path('assets'),
            ], 'esanj-layout-master-assets');

            $this->publishes([
                $this->packagePath('static') => base_path(),
            ], 'esanj-layout-master-static');

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
