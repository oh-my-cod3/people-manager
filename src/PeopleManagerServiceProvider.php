<?php

namespace OhMyCod3\PeopleManager;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use OhMyCod3\PeopleManager\Console\Commands\ImportPeopleFromApiCommand;


class PeopleManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->registerRoutes();

        if ($this->app->runningInConsole()) {
            
            // Registering package commands.
            $this->commands([
                ImportPeopleFromApiCommand::class
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'people-manager');

        // Register the main class to use with the facade
        $this->app->singleton('people-manager', function () {
            return new PeopleManager;
        });
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => 'api',
            'middleware' => 'api',
        ];
    }

}
