<?php

namespace Suifengpiao\Admin;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{



    /**
     * @var array
     */
    protected $commands = [
        'Suifengpiao\Admin\Console\MakeCommand',
        'Suifengpiao\Admin\Console\MenuCommand',
        'Suifengpiao\Admin\Console\InstallCommand',
        'Suifengpiao\Admin\Console\UninstallCommand',
        'Suifengpiao\Admin\Console\ImportCommand',
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
       'backend.bootstrap'  => \Suifengpiao\Admin\Middleware\Bootstrap::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'backend' => [
            'backend.bootstrap',
        ],
    ];

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../config' => config_path()], 'laravel-admin-config');
            $this->publishes([__DIR__.'/../resources/lang' => resource_path('lang')], 'laravel-admin-lang');
//            $this->publishes([__DIR__.'/../resources/views' => resource_path('views/admin')],           'laravel-admin-views');
            $this->publishes([__DIR__.'/../database/migrations' => database_path('migrations')], 'laravel-admin-migrations');
            $this->publishes([__DIR__.'/../resources/assets' => public_path('vendor/laravel-admin')], 'laravel-admin-assets');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->registerRouteMiddleware();

        $this->commands($this->commands);
    }

    /**
     * Setup auth configuration.
     *
     * @return void
     */
    protected function loadAdminAuthConfig()
    {
        config(array_dot(config('admin.auth', []), 'auth.'));
    }

    /**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware()
    {
        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }

        // register middleware group.
        foreach ($this->middlewareGroups as $key => $middleware) {
            app('router')->middlewareGroup($key, $middleware);
        }
    }
}
