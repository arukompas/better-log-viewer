<?php

namespace Arukompas\BetterLogViewer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LogViewerController extends Controller
{
    public function index()
    {
        return view('better-log-viewer::logs.index');
    }
}
