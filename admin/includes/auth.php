<?php

session_start();


if (!isset($_SESSION['usuario'])) {


    header("Location: http://localhost:8080/faustino_motors_multimarcas/admin/login");

    exit;
}
