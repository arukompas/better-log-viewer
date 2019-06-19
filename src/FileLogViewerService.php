<?php

namespace Arukompas\BetterLogViewer;

use Illuminate\Support\Facades\Cache;

class FileLogViewerService
{
    /**
     * Max file size support
     * 
     * @var int
     */
    const MAX_FILE_SIZE = 52428800;

    /**
     * @var array
     */
    private $patterns = [
        'logs' => '/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?\].*/',
        'current_log' => [
            '/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?)\](?:.*?(\w+)\.|.*?)',
            ': (.*?)( in .*?:[0-9]+)?$/i'
        ],
        'files' => '/\{.*?\,.*?\}/i',
    ];

    /**
     * @var array
     */
    public $levels_classes = [
        'debug' => 'info',
        'info' => 'info',
        'notice' => 'info',
        'warning' => 'warning',
        'error' => 'danger',
        'critical' => 'danger',
        'alert' => 'danger',
        'emergency' => 'danger',
        'processed' => 'info',
        'failed' => 'warning',
    ];
    /**
     * @var array
     */
    private $levels_imgs = [
        'debug' => 'info-circle',
        'info' => 'info-circle',
        'notice' => 'info-circle',
        'warning' => 'exclamation-triangle',
        'error' => 'exclamation-triangle',
        'critical' => 'exclamation-triangle',
        'alert' => 'exclamation-triangle',
        'emergency' => 'exclamation-triangle',
        'processed' => 'info-circle',
        'failed' => 'exclamation-triangle'
    ];

    public function getFiles($withCachedCounts = false)
    {
        $files = [];
        foreach (config('better-log-viewer.include_files', []) as $pattern) {
            $files = array_merge($files, glob(storage_path() . '/logs/' . $pattern));
        }

        foreach (config('better-log-viewer.exclude_files', []) as $pattern) {
            $files = array_diff($files, glob(storage_path() . '/logs/' . $pattern));
        }

        $files = array_reverse($files);
        $files = array_filter($files, 'is_file');

        if (is_array($files)) {
            foreach ($files as $k => $file) {
                $fileEntry = [
                    'public_url' => route('better-log-viewer::api.logs.show', basename($file)),
                    'name' => basename($file),
                    'path' => $file,
                    'size' => filesize($file),
                ];

                if ($withCachedCounts) {
                    $key = $file . '::' . md5_file($file) . '::counts';

                    if (Cache::has($key)) {
                        $counts = Cache::get($key);
                        $fileEntry['counts'] = $counts;
                    }
                }

                $files[$k] = $fileEntry;
            }
        }

        return collect($files)->sortByDesc('name');
    }

    public function getFile($name)
    {
        $files = $this->getFiles();

        foreach ($files as $file) {
            if ($file['name'] == $name) {
                return $file;
            }
        }
    }

    public function getLevelCountsForFile($file)
    {
        $key = $file['path'] . '::' . md5_file($file['path']) . '::counts';

        if (Cache::has($key)) {
            $counts = Cache::get($key);
        } else {
            $counts = [];

            foreach (array_keys($this->levels_classes) as $level) {
                $counts[$level] = [
                    'count' => 0,
                    'level_class' => $this->levels_classes[$level]
                ];
            }

            $this->getLogsForFile($file, null, $counts);

            Cache::put($key, $counts, 60 * 24 * 30);    // 30 days expiry
        }

        return $counts;
    }

    public function getLogsForFile($file, $levels = null, &$count = null)
    {
        if (is_null($levels)) {
            $levels = array_keys($this->levels_classes);
        }

        $log = array();

        if (app('files')->size($file['path']) > self::MAX_FILE_SIZE) {
            return null;
        }

        $file = app('files')->get($file['path']);
        $headings = null;
        preg_match_all($this->patterns['logs'], $file, $headings);

        if (!is_array($headings)) {
            return $log;
        }

        $log_data = preg_split($this->patterns['logs'], $file);

        if ($log_data[0] < 1) {
            array_shift($log_data);
        }

        foreach ($headings as $h) {
            for ($i = 0, $j = count($h); $i < $j; $i++) {
                foreach (array_keys($this->levels_classes) as $level) {
                    if (strpos(strtolower($h[$i]), '.' . $level) || strpos(strtolower($h[$i]), $level . ':')) {
                        $current = [];
                        preg_match($this->patterns['current_log'][0] . $level . $this->patterns['current_log'][1], $h[$i], $current);

                        if (!isset($current[4])) continue;

                        if (in_array($level, $levels)) {
                            $log[] = array(
                                'context' => $current[3],
                                'level' => $level,
                                'level_class' => $this->levels_classes[$level],
                                'level_img' => $this->levels_imgs[$level],
                                'date' => $current[1],
                                'text' => mb_convert_encoding($current[4], 'UTF-8', 'UTF-8'),
                                'in_file' => isset($current[5]) ? $current[5] : null,
                                'stack' => mb_convert_encoding(preg_replace("/^\n*/", '', $log_data[$i]), 'UTF-8', 'UTF-8')
                            );
                        }

                        if (!is_null($count) && isset($count[$level])) {
                            $count[$level]['count']++;
                        }
                    }
                }
            }
        }

        if (empty($log)) {
            $lines = explode(PHP_EOL, $file);
            $log = [];
            foreach ($lines as $key => $line) {
                $log[] = [
                    'context' => '',
                    'level' => '',
                    'level_class' => '',
                    'level_img' => '',
                    'date' => $key + 1,
                    'text' => $line,
                    'in_file' => null,
                    'stack' => '',
                ];
            }
        }

        return array_reverse($log);
    }
}
