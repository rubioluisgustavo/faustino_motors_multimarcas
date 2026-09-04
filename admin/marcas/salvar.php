<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../../app/bootstrap.php';

$marcaRepository = new App\Repositories\MarcaRepository($pdo);

$id = isset($_POST['id']) && $_POST['id'] !== '' ? (int) $_POST['id'] : null;
$nome = trim($_POST['nome'] ?? '');

if ($nome === '') {
    header('Location: cadastro.php' . ($id ? '?id=' . $id : ''));
    exit;
}

$marca = new App\Models\Marca($id, $nome);
$marcaRepository->salvar($marca);

header('Location:index.php');
exit;
