<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Better Log Viewer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @better_log_viewer_css

    <script>
        window.route_path = "{{ str_finish(route('better-log-viewer::log.index'), '/') }}";
    </script>
</head>
<body>
    <div id="app">
        <app-layout></app-layout>
    </div>

    @better_log_viewer_js

</body>
</html>
