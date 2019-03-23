<?php

namespace Arukompas\BetterLogViewer\Tools;

use Illuminate\Support\Facades\Blade;

class BladeDirectives
{
    /**
     * Register new Blade functions.
     *
     * @return void
     */
    public function load()
    {
        $this->registerAssetDirectives();
    }

    /**
     * Register asset directives.
     *
     * @return void
     */
    public function registerAssetDirectives()
    {
        Blade::directive('better_log_viewer_css', function() {
            return "<link rel=\"stylesheet\" type=\"text/css\" href=\"<?php echo route('better-log-viewer::assets.css', filemtime('".$this->getAssetPath()."/css/app.css')); ?>\">";
        });

        Blade::directive('better_log_viewer_js', function() {
            return "<script src=\"<?php echo route('better-log-viewer::assets.js', filemtime('".$this->getAssetPath()."/js/app.js')); ?>\"></script>";
        });
    }

    protected function getAssetPath()
    {
        return __DIR__.'/../../public';
    }
}
