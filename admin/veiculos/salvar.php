<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";


// =============================
// DADOS RECEBIDOS
// =============================

$id = $_POST['id'] ?? null;

$id_modelo = $_POST['id_modelo'];
$ano = $_POST['ano'];
$km = $_POST['km'];
$cambio = $_POST['cambio'];
$combustivel = $_POST['combustivel'];
$descricao = $_POST['descricao'];

// Opcionais selecionados
$opcionais = $_POST['opcionais'] ?? [];


// =============================
// TRATAMENTO DO VALOR
// =============================

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


    // Cria pasta se não existir

    if (!is_dir($pasta)) {

        mkdir($pasta, 0777, true);
    }


    $extensao = pathinfo(
        $_FILES['imagem_principal']['name'],
        PATHINFO_EXTENSION
    );


    $nomeArquivo = time() . "_" . uniqid() . "." . $extensao;


    $destino = $pasta . $nomeArquivo;


    if (
        move_uploaded_file(
            $_FILES['imagem_principal']['tmp_name'],
            $destino
        )
    ) {

        $imagem = "img/carros/" . $nomeArquivo;
    }
}


// =============================
// TRANSAÇÃO
// =============================

$pdo->beginTransaction();


try {


    // =============================
    // EDITAR
    // =============================

    if ($id) {


        // -----------------------------
        // Com nova imagem
        // -----------------------------

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
        }


        // -----------------------------
        // Sem nova imagem
        // -----------------------------

        else {

            $sql = $pdo->prepare("

                UPDATE veiculos SET

                    id_modelo = ?,
                    ano = ?,
                    km = ?,
                    cambio = ?,
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


        // O ID continua sendo o mesmo
        $id_veiculo = $id;
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


        // Pega o ID do veículo recém-criado
        $id_veiculo = $pdo->lastInsertId();
    }


    // =============================
    // OPCIONAIS
    // =============================

    // Primeiro remove os opcionais
    // que estavam vinculados ao veículo.

    $sql = $pdo->prepare("

        DELETE FROM veiculos_opcionais

        WHERE id_veiculo = ?

    ");

    $sql->execute([
        $id_veiculo
    ]);


    // =============================
    // INSERE OS NOVOS OPCIONAIS
    // =============================

    if (!empty($opcionais)) {


        $sql = $pdo->prepare("

            INSERT INTO veiculos_opcionais

            (
                id_veiculo,
                id_opcionais
            )

            VALUES (?, ?)

        ");


        foreach ($opcionais as $id_opcional) {

            $sql->execute([

                $id_veiculo,
                $id_opcional

            ]);
        }
    }


    // =============================
    // CONFIRMA
    // =============================

    $pdo->commit();


    // =============================
    // RETORNA PARA LISTA
    // =============================

    header("Location: index.php");

    exit;
} catch (Exception $e) {


    // Se alguma coisa der errado,
    // desfaz todas as alterações.

    $pdo->rollBack();


    die("Erro ao salvar veículo: "
        . $e->getMessage());
}
