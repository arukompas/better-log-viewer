<?php

namespace Arukompas\BetterLogViewer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class BetterLogViewerProvider extends ServiceProvider
{
    protected $namespace = 'Arukompas\BetterLogViewer\Http\Controllers';

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mapWebRoutes();
        $this->mapApiRoutes();

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/arukompas/better-log-viewer'),
            __DIR__.'/../fonts' => public_path('fonts'),
        ], 'assets');

        $this->publishes([
            __DIR__.'/config/better-log-viewer.php' => config_path('config/better-log-viewer.php'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'better-log-viewer');

        $this->mergeConfigFrom(
            __DIR__.'/config/better-log-viewer.php', 'better-log-viewer'
        );
    }

    protected function mapWebRoutes()
    {
        Route::prefix(config('better-log-viewer.route_path', 'log-viewer'))
            ->middleware(config('better-log-viewer.middleware', ['web']))
            ->namespace($this->namespace)
            ->group(__DIR__.'/routes/web.php');
    }

    protected function mapApiRoutes()
    {
        Route::prefix(str_finish(config('better-log-viewer.route_path'), '/') . 'api')
            ->middleware(config('better-log-viewer.api_middleware', ''))
            ->namespace($this->namespace . '\Api')
            ->group(__DIR__.'/routes/api.php');
    }
}
