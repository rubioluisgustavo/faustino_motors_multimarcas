<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";
require_once __DIR__ . '/VendaRepository.php';

$id = isset($_POST['id']) && $_POST['id'] !== '' ? (int) $_POST['id'] : null;
$nome = trim($_POST['nome'] ?? '');
$depoimento = trim($_POST['depoimento'] ?? '');

if ($nome === '') {
    header('Location: cadastro.php' . ($id ? '?id=' . $id : ''));
    exit;
}

$imagem = null;
if (isset($_FILES['imagem_principal']) && $_FILES['imagem_principal']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['imagem_principal']['error'] !== UPLOAD_ERR_OK) {
        die('Erro ao enviar a imagem.');
    }

    $extensao = strtolower(pathinfo($_FILES['imagem_principal']['name'], PATHINFO_EXTENSION));
    $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
    if (!in_array($extensao, $extensoesPermitidas, true)) {
        die('Formato de imagem não permitido.');
    }

    $pasta = "../../img/vendas/";
    if (!is_dir($pasta) && !mkdir($pasta, 0755, true)) {
        die('Não foi possível preparar a pasta de imagens.');
    }

    $nomeArquivo = time() . '_' . uniqid('', true) . '.' . $extensao;
    if (!move_uploaded_file($_FILES['imagem_principal']['tmp_name'], $pasta . $nomeArquivo)) {
        die('Não foi possível salvar a imagem.');
    }
    $imagem = 'img/vendas/' . $nomeArquivo;
}

$repository = new VendaRepository($pdo);
$repository->salvar(new Venda([
    'id' => $id,
    'nome' => $nome,
    'depoimento' => $depoimento,
]), $imagem);

header('Location: index.php');
exit;
