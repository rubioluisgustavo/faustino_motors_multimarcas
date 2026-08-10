<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";


// Dados recebidos

$id = $_POST['id'] ?? null;

$id_marca = $_POST['id_marca'] ?? null;

$nome = $_POST['nome'] ?? '';





// =============================
// EDITAR
// =============================

if ($id) {


    $sql = $pdo->prepare("

        UPDATE modelos SET

            id_marca = ?,

            nome = ?


        WHERE id = ?

    ");



    $sql->execute([

        $id_marca,

        $nome,

        $id

    ]);
} else {



    // =============================
    // NOVO CADASTRO
    // =============================


    $sql = $pdo->prepare("

        INSERT INTO modelos

        (

            id_marca,

            nome

        )


        VALUES

        (

            ?,

            ?

        )

    ");



    $sql->execute([

        $id_marca,

        $nome

    ]);
}





// retorna para lista

header("Location: index.php");

exit;
