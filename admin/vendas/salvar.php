<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";
require_once __DIR__ . '/VendaRepository.php';
require_once __DIR__ . '/../../includes/image_upload.php';

$id = isset($_POST['id']) && $_POST['id'] !== '' ? (int) $_POST['id'] : null;
$nome = trim($_POST['nome'] ?? '');
$depoimento = trim($_POST['depoimento'] ?? '');

if ($nome === '') {
    header('Location: ' . site_path() . '/admin/vendas/cadastro.php' . ($id ? '?id=' . $id : ''));
    exit;
}

try {
    $imagem = null;
    if (isset($_FILES['imagem_principal']) && $_FILES['imagem_principal']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['imagem_principal']['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Erro ao enviar a imagem principal.');
        }
        $imagem = storeUploadedImage(
            $_FILES['imagem_principal']['tmp_name'],
            $_FILES['imagem_principal']['name'],
            __DIR__ . '/../../img/vendas',
            'img/vendas'
        );
    }

    $imagensExtras = [];
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
                __DIR__ . '/../../img/vendas',
                'img/vendas'
            );
        }
    }

    $repository = new VendaRepository($pdo);
    $pdo->beginTransaction();
    $idVenda = $repository->salvar(new Venda([
        'id' => $id,
        'nome' => $nome,
        'depoimento' => $depoimento,
    ]), $imagem);
    $repository->adicionarImagens($idVenda, $imagensExtras);
    $pdo->commit();
} catch (RuntimeException $exception) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(400);
    exit(htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8'));
} catch (PDOException $exception) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log('Erro ao salvar venda: ' . $exception->getMessage());
    http_response_code(500);
    exit('Não foi possível salvar a venda.');
}

header('Location: ' . site_path() . '/admin/vendas/');
exit;
