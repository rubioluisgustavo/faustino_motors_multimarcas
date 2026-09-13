<?php

require_once dirname(__DIR__, 2) . '/config.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// var_dump($_SESSION['usuario']['nome']);
// exit;


if (!isset($_SESSION['usuario'])) {
    header('Location: ' . site_path() . '/admin/login/');
    exit;
}

function usuarioPodeGerenciarUsuarios(): bool
{
    return strtolower((string) ($_SESSION['usuario']['nome'] ?? '')) === 'admin_luis';
}

function exigirPermissaoGerenciarUsuarios(): void
{
    if (!usuarioPodeGerenciarUsuarios()) {
        http_response_code(403);
        exit('Você não tem permissão para gerenciar usuários.');
    }
}
