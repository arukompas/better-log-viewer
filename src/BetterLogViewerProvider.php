<?php

namespace Arukompas\BetterLogViewer;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Arukompas\BetterLogViewer\Tools\BladeDirectives;

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
        $this->mapAssetRoutes();
        $this->loadTools();

        $this->publishes([
            __DIR__.'/config/better-log-viewer.php' => config_path('better-log-viewer.php'),
        ], 'config');
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
        Route::group([
            'prefix' => config('better-log-viewer.route_path', 'log-viewer'),
            'middleware' => config('better-log-viewer.middleware', ''),
            'namespace' => $this->namespace,
        ], function () {
            require __DIR__.'/routes/web.php';
        });
    }

    protected function mapApiRoutes()
    {
        Route::group([
            'prefix' => Str::finish(config('better-log-viewer.route_path'), '/') . 'api',
            'middleware' => config('better-log-viewer.api_middleware', ''),
            'namespace' => $this->namespace . '\Api',
        ], function () {
            require __DIR__.'/routes/api.php';
        });
    }

    protected function mapAssetRoutes()
    {
        Route::group([
            'prefix' => Str::finish(config('better-log-viewer.route_path', 'log-viewer'), '/') . 'assets',
            'middleware' => config('better-log-viewer.api_middleware', ''),
            'namespace' => $this->namespace,
        ], function () {
            require __DIR__.'/routes/assets.php';
        });
    }

    protected function loadTools()
    {
        (new BladeDirectives)->load();
    }
}
