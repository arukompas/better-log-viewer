<?php

namespace Arukompas\BetterLogViewer\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Routing\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Arukompas\BetterLogViewer\FileLogViewerService;

class LogsController extends Controller
{
    public function index(FileLogViewerService $logViewer)
    {
        return $logViewer->getFiles(true);
    }

    public function show(Request $request, $name, FileLogViewerService $logViewer)
    {
        $levels = explode(",", $request->query('levels', ''));
        $perPage = (int)$request->query('perPage', 10);
        $query = $request->query('query', '');
        $counts = [];
        foreach (array_keys($logViewer->levels_classes) as $level) {
            $counts[$level] = [
                'count' => 0,
                'level_class' => $logViewer->levels_classes[$level]
            ];
        }

        if (empty($levels) || (count($levels) == 1) && $levels[0] == '') {
            $logs = [];
        } else {
            $file = $logViewer->getFile($name);
            $logs = collect($logViewer->getLogsForFile($file, $levels));
        }

        if (!empty($query)) {
            $query = "/" . $query . "/i";
            $logs = $logs->filter(function ($log) use ($query) {
                return preg_match($query, $log['date'])
                    || preg_match($query, $log['text'])
                    || preg_match($query, $log['stack']);
            });
        }

        return array_merge($this->paginate($logs, $perPage)->toArray(), [
            'counts' => $counts,
            'response_time' => microtime(true) - LARAVEL_START,
            'response_peak_memory' => memory_get_peak_usage()
        ]);
    }

    /**
     * Paginate a collection of items
     *
     * @param  array|Collection  $items
     * @param  int  $perPage
     * @param  int  $page
     * @param  array $options
     *
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
