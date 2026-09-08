<?php

require_once dirname(__DIR__, 2) . '/config.php';
session_start();


if (!isset($_SESSION['usuario'])) {
    header('Location: ' . site_path() . '/admin/login/');
    exit;
}
