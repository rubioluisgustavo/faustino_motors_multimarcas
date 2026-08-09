<?php

session_start();


require_once "../../conexao.php";


$email = $_POST['email'] ?? '';

$senha = $_POST['senha'] ?? '';



$sql = $pdo->prepare("

    SELECT *

    FROM usuarios

    WHERE email = ?

");


$sql->execute([$email]);


$usuario = $sql->fetch(PDO::FETCH_ASSOC);



if (
    $usuario &&
    password_verify($senha, $usuario['senha'])
) {


    $_SESSION['usuario'] = [

        'id' => $usuario['id'],

        'nome' => $usuario['nome']

    ];



    header("Location: ../index.php");

    exit;
}



header("Location:index.php?erro=1");

exit;
