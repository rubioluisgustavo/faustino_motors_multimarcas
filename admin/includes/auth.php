<?php

session_start();


if (!isset($_SESSION['usuario'])) {


    header("Location: /new/admin/login");

    exit;
}
