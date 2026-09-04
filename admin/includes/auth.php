<?php

require_once __DIR__ . '/../../app/Support/helpers.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    redirect('admin/login');
}
