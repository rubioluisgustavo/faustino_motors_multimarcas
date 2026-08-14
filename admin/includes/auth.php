<?php

session_start();


if (!isset($_SESSION['usuario'])) {

    if (
        $_SERVER['SERVER_NAME'] === 'localhost' ||
        $_SERVER['SERVER_NAME'] === '127.0.0.1'
    ) {
        header("Location: login");
    } else {
        header("Location: /new/admin/login");
    }

    exit;
}
