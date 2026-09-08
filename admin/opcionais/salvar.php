<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";
require_once __DIR__ . '/OpcionalRepository.php';

// Dados recebidos

$id = isset($_POST['id']) && $_POST['id'] !== '' ? (int) $_POST['id'] : null;
$nome = trim($_POST['nome'] ?? '');

if ($nome === '') {
    header('Location: ' . site_path() . '/admin/opcionais/cadastro.php' . ($id ? '?id=' . $id : ''));
    exit;
}

(new OpcionalRepository($pdo))->salvar(new Opcional($id, $nome));



// retorna para lista

header("Location:" . site_path() . "/admin/opcionais/");

exit;
