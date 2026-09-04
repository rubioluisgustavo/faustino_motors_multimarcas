<?php

session_start();


require_once "../../conexao.php";


$email = trim($_POST['email'] ?? '');

$senha = $_POST['senha'] ?? '';



$sql = $pdo->prepare("

    SELECT id, nome, senha

    FROM usuarios

    WHERE email = ?

");


$sql->execute([$email]);


$usuario = $sql->fetch(PDO::FETCH_ASSOC);



if (
    $usuario &&
    password_verify($senha, $usuario['senha'])
) {
    session_regenerate_id(true);


    $_SESSION['usuario'] = [

        'id' => $usuario['id'],

        'nome' => $usuario['nome']

    ];



    header("Location: ../index.php");

    exit;
}



header("Location:index.php?erro=1");

exit;
