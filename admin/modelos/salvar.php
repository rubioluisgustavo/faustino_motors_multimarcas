<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../../app/bootstrap.php';

$modeloRepository = new App\Repositories\ModeloRepository($pdo);

$id = isset($_POST['id']) && $_POST['id'] !== '' ? (int) $_POST['id'] : null;
$idMarca = isset($_POST['id_marca']) && $_POST['id_marca'] !== '' ? (int) $_POST['id_marca'] : null;
$nome = trim($_POST['nome'] ?? '');

if ($idMarca === null || $nome === '') {
    header('Location: cadastro.php' . ($id ? '?id=' . $id : ''));
    exit;
}

$modelo = new App\Models\Modelo($id, $idMarca, $nome);
$modeloRepository->salvar($modelo);

header('Location: index.php');
exit;
