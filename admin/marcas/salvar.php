<?php

require_once "../../conexao.php";


// Dados recebidos

$id = $_POST['id'] ?? null;
$nome = $_POST['nome'];


// =============================
// EDITAR
// =============================

if ($id) {



    // mantém imagem atual

    $sql = $pdo->prepare("

            UPDATE marcas SET
                nome = ?

            WHERE id = ?

        ");


    $sql->execute([

        $nome,
        $id

    ]);
} else {


    $sql = $pdo->prepare("

        INSERT INTO marcas

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
