<?php

session_start();


if (!isset($_SESSION['usuario'])) {

    $adminPath = rtrim(str_replace('\\', '/', dirname(dirname($_SERVER['SCRIPT_NAME']))), '/');
    header("Location: {$adminPath}/login/");

    exit;
}
