<?php

namespace Arukompas\BetterLogViewer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AssetController extends Controller
{
    public function css()
    {
        return response()
            ->make(file_get_contents(__DIR__.'/../../../public/css/app.css'), 200)
            ->header('Content-Type', 'text/css');
    }

    public function js()
    {
        return response()
            ->make(file_get_contents(__DIR__.'/../../../public/js/app.js'), 200)
            ->header('Content-Type', 'application/javascript');
    }
}
