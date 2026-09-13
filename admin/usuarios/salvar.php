<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";
require_once __DIR__ . '/UsuarioRepository.php';

exigirPermissaoGerenciarUsuarios();

$usuarioRepository = new UsuarioRepository($pdo);
$id = isset($_POST['id']) && $_POST['id'] !== '' ? (int) $_POST['id'] : null;
$email = strtolower(trim($_POST['email'] ?? ''));
$senha = $_POST['senha'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || ($id === null && $senha === '') || $usuarioRepository->existeEmail($email, $id)) {
    $query = $id ? '?id=' . $id . '&erro=1' : '?erro=1';
    header('Location: ' . site_path() . '/admin/usuarios/cadastro.php' . $query);
    exit;
}

$usuarioRepository->salvar(new Usuario($id, $email, $senha));

header('Location: ' . site_path() . '/admin/usuarios/');
exit;
