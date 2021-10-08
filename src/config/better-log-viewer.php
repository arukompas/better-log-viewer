<?php

return [
    /**
     * Log Viewer route path.
     */
    'route_path' => 'log-viewer',

    /**
     * Log Viewer route middleware
     */
    'middleware' => [],

    /**
     * Log Viewer API middleware
     */
    'api_middleware' => [],

    /**
     * Include file patterns
     */
    'include_files' => ['*.log'],

    /**
     * Exclude file patterns. This will take precedence
     */
    'exclude_files' => [],

    /**
     * Shorter stack trace filters. Any lines matching these regex patters will be excluded.
     */
    'shorter_stack_trace_excludes' => [
        '/vendor/symfony/',
        '/vendor/laravel/framework/',
        '/vendor/barryvdh/laravel-debugbar/'
    ],

    /**
     * Timezone for which the log entries will be displayed in
     * 
     * You can change this value to any valid timezone string if you want to display logs 
     * in a different timezone then that of the applciation. Eg: 'timezone' => 'Europe/Copenhagen'
     */
    'timezone' => config('app.timezone', 'UTC'),
];
