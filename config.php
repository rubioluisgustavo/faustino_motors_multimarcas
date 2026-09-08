<?php

if (!function_exists('site_path')) {
    function site_path(): string
    {
        $scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
        $adminPosition = strpos($scriptPath, '/admin/');

        if ($adminPosition !== false) {
            return substr($scriptPath, 0, $adminPosition);
        }

        $sqlPosition = strpos($scriptPath, '/sql/');

        if ($sqlPosition !== false) {
            return substr($scriptPath, 0, $sqlPosition);
        }

        $directory = str_replace('\\', '/', dirname($scriptPath));

        if ($directory === '/' || $directory === '.' || $directory === '\\') {
            return '';
        }

        return rtrim($directory, '/');
    }
}
