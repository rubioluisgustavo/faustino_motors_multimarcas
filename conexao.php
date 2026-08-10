<?php

/*
|--------------------------------------------------------------------------
| CONFIGURAÇÃO DO BANCO DE DADOS
|--------------------------------------------------------------------------
| Detecta automaticamente se está rodando:
|
| - Local: XAMPP
| - Produção: Hostinger
|
|--------------------------------------------------------------------------
*/


if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1') {

    // =========================================================
    // AMBIENTE LOCAL - XAMPP
    // =========================================================

    $host = "localhost";
    $dbname = "faustino_motors_multimarcas";
    $user = "root";
    $password = "";

} else {

    // =========================================================
    // AMBIENTE DE PRODUÇÃO - HOSTINGER
    // =========================================================

    $host = "localhost";
    $dbname = "u458022580_faustinoProd";
    $user = "u458022580_raiz";

    // COLOQUE A NOVA SENHA DO BANCO DA HOSTINGER AQUI
    $password = "SUA_NOVA_SENHA_AQUI";
}


/*
|--------------------------------------------------------------------------
| CONEXÃO PDO
|--------------------------------------------------------------------------
*/

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $password
    );


    /*
    |--------------------------------------------------------------------------
    | Configurações do PDO
    |--------------------------------------------------------------------------
    */

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $pdo->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );


} catch (PDOException $e) {

    /*
    |--------------------------------------------------------------------------
    | Não exibir detalhes da conexão em produção
    |--------------------------------------------------------------------------
    */

    die("Erro ao conectar ao banco de dados.");

}