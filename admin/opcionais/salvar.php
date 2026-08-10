<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";

// Dados recebidos

$id = $_POST['id'] ?? null;
$nome = $_POST['nome'];


// =============================
// EDITAR
// =============================

if ($id) {



    // mant�m imagem atual

    $sql = $pdo->prepare("

            UPDATE opcionais SET
                nome = ?

            WHERE id = ?

        ");


    $sql->execute([

        $nome,
        $id

    ]);
} else {


    $sql = $pdo->prepare("

        INSERT INTO opcionais

        (
            nome
        )

        VALUES
        (?)

    ");



    $sql->execute([

        $nome
    ]);
}



// retorna para lista

header("Location:index.php");

exit;
