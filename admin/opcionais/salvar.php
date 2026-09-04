<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../../app/bootstrap.php';

$opcionalRepository = new App\Repositories\OpcionalRepository($pdo);

$id = isset($_POST['id']) && $_POST['id'] !== '' ? (int) $_POST['id'] : null;
$nome = trim($_POST['nome'] ?? '');

if ($nome === '') {
    header('Location: cadastro.php' . ($id ? '?id=' . $id : ''));
    exit;
}

$opcional = new App\Models\Opcional($id, $nome);
$opcionalRepository->salvar($opcional);

header('Location:index.php');
exit;
