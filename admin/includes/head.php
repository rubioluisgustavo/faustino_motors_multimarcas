<?php

$scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$faviconPath = preg_match('#/admin/[^/]+/[^/]+$#', $scriptPath)
    ? '../../img/favicon-16x16.png'
    : '../img/favicon-16x16.png';

require_once dirname(__DIR__, 2) . '/includes/head.php';
require_once dirname(__DIR__, 2) . '/includes/assets.php';
