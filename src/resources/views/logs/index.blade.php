<!DOCTYPE html>
<html class="max-h-screen">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Better Log Viewer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    @better_log_viewer_css

    <script>
        window.route_path = "{{ str_finish(route('better-log-viewer::log.index'), '/') }}";
        window.shorter_stack_trace_excludes = {!! json_encode(config('better-log-viewer.shorter_stack_trace_excludes')) !!};
    </script>
</head>
<body class="font-sans text-sm bg-grey-light max-h-screen leading-tight">
    <div id="app">
        <app-layout></app-layout>
    </div>

    @better_log_viewer_js

</body>
</html>
