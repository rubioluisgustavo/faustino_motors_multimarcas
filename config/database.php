<?php

$serverName = $_SERVER['SERVER_NAME'] ?? 'localhost';
$isLocal = PHP_SAPI === 'cli' || in_array($serverName, ['localhost', '127.0.0.1'], true);

if ($isLocal) {
    $host = "localhost";
    $dbname = "faustino_motors_multimarcas";
    $user = "root";
    $password = "Bella251176!";
} else {
    $host = getenv('DB_HOST') ?: 'localhost';
    $dbname = getenv('DB_DATABASE') ?: '';
    $user = getenv('DB_USERNAME') ?: '';
    $password = getenv('DB_PASSWORD') ?: '';

    if ($dbname === '' || $user === '') {
        die('Configure as variaveis de ambiente DB_DATABASE e DB_USERNAME.');
    }
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
