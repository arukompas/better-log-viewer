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
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'better-log-viewer');
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__.'/routes/web.php');
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace . '\Api')
            ->group(__DIR__.'/routes/api.php');
    }
}
