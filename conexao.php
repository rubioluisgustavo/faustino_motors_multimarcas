<?php

if (
    $_SERVER['SERVER_NAME'] === 'localhost' ||
    $_SERVER['SERVER_NAME'] === '127.0.0.1'
) {
    $host = "localhost";
    $dbname = "faustino_motors_multimarcas";
    $user = "root";
    $password = "";
} else {

    // Ambiente produção - Hostinger

    $host = "localhost";
    $dbname = "u458022580_5HHE2";
    $user = "u458022580_mz51w";
    $password = "FaustinoMotorsMultimarcas123!!!";
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
    error_log('Falha na conexão com o banco de dados: ' . $e->getMessage());
    http_response_code(500);
    exit('Não foi possível conectar ao banco de dados.');
}
