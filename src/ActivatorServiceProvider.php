<?php

namespace Modricl\Activator;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Modricl\Activator\Http\Middleware\AuthorizationMiddleware;

class ActivatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the package's services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // Export the migration
            if (!class_exists('CreateActivationCodesTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_activation_codes_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_activation_codes_table.php'),
                    // you can add any number of migrations here
                ], 'migrations');
            }
        }

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->mergeConfigFrom(__DIR__ . '/../config/database.php', 'database.connections');

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('activator', AuthorizationMiddleware::class);
    }

    /**
     * Register the package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'activator');
    }
}
