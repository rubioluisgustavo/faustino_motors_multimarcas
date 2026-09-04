<?php

session_start();

require_once __DIR__ . '/../../app/bootstrap.php';

$usuarioRepository = new App\Repositories\UsuarioRepository($pdo);

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

$usuario = $usuarioRepository->autenticar($email, $senha);

if ($usuario) {
    $_SESSION['usuario'] = [
        'id' => $usuario->getId(),
        'nome' => $usuario->getNome(),
    ];

    header('Location: ../index.php');
    exit;
}

header('Location:index.php?erro=1');
exit;
