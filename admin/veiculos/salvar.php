<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";
require_once __DIR__ . '/../../includes/image_upload.php';
require_once __DIR__ . '/../../includes/vehicle_description.php';
require_once __DIR__ . '/VeiculoRepository.php';

// ============================= 
// DADOS RECEBIDOS 
// ============================= 

$id = $_POST['id'] ?? null;

$id_modelo = $_POST['id_modelo'] ?? '';
$ano = trim($_POST['ano'] ?? '');
$km = $_POST['km'] ?? '';
$cambio = $_POST['cambio'] ?? '';
$combustivel = $_POST['combustivel'] ?? '';
$descricao = sanitizeVehicleDescription($_POST['descricao'] ?? '');
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
$imagensExtras = [];

try {
    if (isset($_FILES['imagem_principal']) && $_FILES['imagem_principal']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['imagem_principal']['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Erro ao enviar a imagem principal.');
        }
        $imagem = storeUploadedImage(
            $_FILES['imagem_principal']['tmp_name'],
            $_FILES['imagem_principal']['name'],
            __DIR__ . '/../../img/carros',
            'img/carros'
        );
    }

    if (isset($_FILES['imagens'])) {
        foreach ($_FILES['imagens']['error'] as $index => $error) {
            if ($error === UPLOAD_ERR_NO_FILE) {
                continue;
            }
            if ($error !== UPLOAD_ERR_OK) {
                throw new RuntimeException('Erro ao enviar uma das fotos adicionais.');
            }
            $imagensExtras[] = storeUploadedImage(
                $_FILES['imagens']['tmp_name'][$index],
                $_FILES['imagens']['name'][$index],
                __DIR__ . '/../../img/carros',
                'img/carros'
            );
        }
    }
} catch (RuntimeException $exception) {
    http_response_code(400);
    exit(htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8'));
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

        if ($imagem) {
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
        } else {
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

    (new VeiculoRepository($pdo))->adicionarImagens((int) $id_veiculo, $imagensExtras);

    // ============================= 
    // CONFIRMA 
    // ============================= 
    $pdo->commit();

    // ============================= 
    // RETORNA PARA LISTA 
    // ============================= 
    header("Location: " . site_path() . "/admin/veiculos/");
    exit;
} catch (Exception $e) {
    $pdo->rollBack();
    die("Erro ao salvar veículo: " . $e->getMessage());
}
