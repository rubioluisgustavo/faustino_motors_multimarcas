<?php

error_reporting(E_ERROR);
ini_set('display_errors', 1);

require_once __DIR__ . '/app/bootstrap.php';

(new App\Router($pdo))->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
