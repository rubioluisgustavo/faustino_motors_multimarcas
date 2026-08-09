<?php

require_once "../../conexao.php";


// Dados recebidos

$id = $_POST['id'] ?? null;

$id_modelo = $_POST['id_modelo'];
$ano = $_POST['ano'];
$km = $_POST['km'];
$cambio = $_POST['cambio'];
$combustivel = $_POST['combustivel'];
$descricao = $_POST['descricao'];   


// Tratamento do valor

$valor = $_POST['valor'];

$valor = str_replace('.', '', $valor);
$valor = str_replace(',', '.', $valor);



// =============================
// UPLOAD DA IMAGEM
// =============================

$imagem = null;


if (
    isset($_FILES['imagem_principal']) &&
    $_FILES['imagem_principal']['error'] == 0
) {


    $pasta = "../../img/carros/";


    // cria pasta se n�o existir

    if (!is_dir($pasta)) {

        mkdir($pasta, 0777, true);
    }


    $extensao = pathinfo(
        $_FILES['imagem_principal']['name'],
        PATHINFO_EXTENSION
    );


    $nomeArquivo = time() . "_" . uniqid() . "." . $extensao;


    $destino = $pasta . $nomeArquivo;


    if (move_uploaded_file(
        $_FILES['imagem_principal']['tmp_name'],
        $destino
    )) {


        $imagem = "img/carros/" . $nomeArquivo;
    }
}



// =============================
// EDITAR
// =============================

if ($id) {


    // verifica se tem imagem antiga

    if ($imagem) {


        $sql = $pdo->prepare("

            UPDATE veiculos SET

                id_modelo = ?,
                ano = ?,
                km = ?,
                cambio = ?,
                combustivel = ?,
                valor = ?,
                imagem_principal = ?,
                descricao = ?

            WHERE id = ?

        ");


        $sql->execute([

            $id_modelo,
            $ano,
            $km,
            $cambio,
            $combustivel,
            $valor,
            $imagem,
            $descricao,
            $id

        ]);
    } else {


        // mant�m imagem atual

        $sql = $pdo->prepare("

            UPDATE veiculos SET

                id_modelo = ?,
                ano = ?,
                km = ?,
                cambio = ?
                ,
                combustivel = ?,
                valor = ?,
                descricao = ?

            WHERE id = ?

        ");


        $sql->execute([

            $id_modelo,
            $ano,
            $km,
            $cambio,
            $combustivel,
            $valor,
            $descricao,
            $id

        ]);
    }
}


// =============================
// NOVO CADASTRO
// =============================

else {


    $sql = $pdo->prepare("

        INSERT INTO veiculos

        (
            id_modelo,
            ano,
            km,
            cambio,
            combustivel,
            valor,
            imagem_principal,
            descricao
        )

        VALUES
        (?,?,?,?,?,?,?,?)

    ");



    $sql->execute([

        $id_modelo,
        $ano,
        $km,
        $cambio,
        $combustivel,
        $valor,
        $imagem,
        $descricao

    ]);
}



// retorna para lista

header("Location:index.php");

exit;
