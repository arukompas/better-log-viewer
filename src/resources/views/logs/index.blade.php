<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Better Log Viewer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('vendor/arukompas/better-log-viewer/css/app.css') }}" />
</head>
<body>
    <div id="app">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12">
                    <sidebar-nav></sidebar-nav>
                </div>
                <div class="col-lg-8 col-md-7 col-sm-6 col-xs-12">
                    <log-list></log-list>
                </div>
            </div>
            <vue-snotify></vue-snotify>
        </div>
    </div>

    <script src="{{ asset('vendor/arukompas/better-log-viewer/js/app.js') }}"></script>
</body>
</html>