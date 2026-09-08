<?php

require_once dirname(__DIR__) . '/config.php';

$faviconPath = $faviconPath ?? 'img/favicon-16x16.png';

// Report all PHP errors
error_reporting(E_ALL);

// Force errors to be displayed on the screen
ini_set('display_errors', '1');

?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" sizes="16x16" href="<?= htmlspecialchars($faviconPath, ENT_QUOTES, 'UTF-8') ?>">
<meta name="theme-color" content="#ffffff">
<title>Faustino Motors Multimarcas</title>
