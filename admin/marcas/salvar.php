<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";
require_once __DIR__ . '/MarcaRepository.php';

$marcaRepository = new MarcaRepository($pdo);

$id = isset($_POST['id']) && $_POST['id'] !== '' ? (int) $_POST['id'] : null;
$nome = trim($_POST['nome'] ?? '');

if ($nome === '') {
    header('Location: ' . site_path() . '/admin/marcas/cadastro.php' . ($id ? '?id=' . $id : ''));
    exit;
}

$marca = new Marca($id, $nome);
$marcaRepository->salvar($marca);

header("Location:" . site_path() . "/admin/marcas/");
exit;
