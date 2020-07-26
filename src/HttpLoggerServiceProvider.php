<?php

namespace Espora\HttpLogger;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

use Espora\HttpLogger\Commands\PurgeCommand;
use Espora\HttpLogger\Middleware\LogRequest;

class HttpLoggerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/http-logger.php' => config_path('http-logger.php'),
            ], 'config');


            if (! class_exists('CreatePackageTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_http_logs_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_http_logs_table.php'),
                ], 'migrations');
            }

            $this->commands([
                PurgeCommand::class,
            ]);
        }
        // Append the middleware
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('log-request', LogRequest::class);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/http-logger.php', 'http-logger');
    }
}
