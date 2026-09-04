<?php

if (
    $_SERVER['SERVER_NAME'] === 'localhost' ||
    $_SERVER['SERVER_NAME'] === '127.0.0.1'
) {
    $host = "localhost";
    $dbname = "faustino_motors_multimarcas";
    $user = "root";
    $password = "Bella251176!";
} else {

    // Ambiente produção - Hostinger

    // $host = "localhost";
    // $dbname = "u458022580_5HHE2";
    // $user = "u458022580_mz51w";
    // $password = "FaustinoMotorsMultimarcas123!!!";
}

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $password
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $pdo->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );
} catch (PDOException $e) {

    die($e);
}
