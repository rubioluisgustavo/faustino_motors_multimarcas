<?php

require_once dirname(__DIR__, 2) . '/config.php';
session_start();

$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $cookieParams = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $cookieParams['path'],
        $cookieParams['domain'],
        $cookieParams['secure'],
        $cookieParams['httponly']
    );
}

session_unset();
session_destroy();

header('Location: ' . site_path() . '/admin/login/');
exit;