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
$novo = isset($_POST['novo']) && $_POST['novo'] == 'y' ? 'y' : 'n';

// Opcionais selecionados 
$opcionais = $_POST['opcionais'] ?? [];

// ============================= 
// TRATAMENTO DO VALOR 
// ============================= 

$valor = $_POST['valor'];
$valor = str_replace('.', '', $valor);
$valor = str_replace(',', '.', $valor);

$valorPremium = trim($_POST['valor_premium'] ?? '');
$valorPremium = $valorPremium === ''
    ? null
    : str_replace(',', '.', str_replace('.', '', $valorPremium));

// ============================= 
// UPLOAD DA IMAGEM 
// ============================= 

$imagem = null;

if (
    isset($_FILES['imagem_principal']) &&
    $_FILES['imagem_principal']['error'] == 0
) {
    $extensao = strtolower(pathinfo($_FILES['imagem_principal']['name'], PATHINFO_EXTENSION));
    $tiposPermitidos = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'webp' => 'image/webp',
    ];
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($_FILES['imagem_principal']['tmp_name']);

    if (!isset($tiposPermitidos[$extensao]) || $tiposPermitidos[$extensao] !== $mime) {
        die("Formato de imagem não permitido.");
    }

    $pasta = "../../img/carros/";

    if (!is_dir($pasta)) {
        mkdir($pasta, 0755, true);
    }

    $nomeArquivo = bin2hex(random_bytes(16)) . "." . $extensao;
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

        // Com nova imagem 
        if ($imagem) {
            // Corrigido: Removida aspas do ? do campo novo e adicionada a vírgula antes de novo
            $sql = $pdo->prepare(" 
                UPDATE veiculos SET 
                    id_modelo = ?, 
                    ano = ?, 
                    km = ?, 
                    cambio = ?, 
                    combustivel = ?, 
                    valor = ?,
                    valor_premium = ?,
                    imagem_principal = ?, 
                    descricao = ?,
                    novo = ? 
                WHERE id = ? 
            ");

            // Corrigido: Ordem das variáveis sincronizada com a query acima ($novo antes do $id)
            $sql->execute([
                $id_modelo,
                $ano,
                $km,
                $cambio,
                $combustivel,
                $valor,
                $valorPremium,
                $imagem,
                $descricao,
                $novo,
                $id
            ]);
        }

        // Sem nova imagem 
        else {
            // Corrigido: Adicionada a vírgula antes do campo novo e removida a aspas do ?
            $sql = $pdo->prepare(" 
                UPDATE veiculos SET 
                    id_modelo = ?, 
                    ano = ?, 
                    km = ?, 
                    cambio = ?, 
                    combustivel = ?, 
                    valor = ?,
                    valor_premium = ?,
                    descricao = ?,
                    novo = ? 
                WHERE id = ? 
            ");

            $sql->execute([
                $id_modelo,
                $ano,
                $km,
                $cambio,
                $combustivel,
                $valor,
                $valorPremium,
                $descricao,
                $novo,
                $id
            ]);
        }



        $id_veiculo = $id;
    }

    // ============================= 
    // NOVO CADASTRO 
    // ============================= 
    else {

        // Corrigido: Removidas as aspas do '?' do campo novo
        $sql = $pdo->prepare(" 
            INSERT INTO veiculos 
            ( 
                id_modelo, 
                ano, 
                km, 
                cambio, 
                combustivel, 
                valor,
                valor_premium,
                imagem_principal, 
                descricao, 
                novo 
            ) 
            VALUES 
            (?,?,?,?,?,?,?,?,?,?)
        ");

        $sql->execute([
            $id_modelo,
            $ano,
            $km,
            $cambio,
            $combustivel,
            $valor,
            $valorPremium,
            $imagem,
            $descricao,
            $novo
        ]);

        $id_veiculo = $pdo->lastInsertId();
    }

    // ============================= 
    // OPCIONAIS 
    // ============================= 
    $sql = $pdo->prepare(" 
        DELETE FROM veiculos_opcionais 
        WHERE id_veiculo = ? 
    ");

    $sql->execute([$id_veiculo]);

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
    $pdo->rollBack();
    die("Erro ao salvar veículo: " . $e->getMessage());
}
