<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";
require_once __DIR__ . '/UsuarioRepository.php';
require_once __DIR__ . '/../includes/head.php';

exigirPermissaoGerenciarUsuarios();

$usuarioRepository = new UsuarioRepository($pdo);
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
$usuario = $id ? $usuarioRepository->buscarPorId($id) : null;

if ($id !== null && $usuario === null) {
    header('Location: ' . site_path() . '/admin/usuarios/');
    exit;
}

$erro = isset($_GET['erro']);
?>

<link href="../css/admin.css" rel="stylesheet">

<div class="card-admin">
    <?php if ($erro): ?>
        <div class="alert alert-warning">Informe um e-mail válido, uma senha para novos usuários e não repita e-mails cadastrados.</div>
    <?php endif; ?>

    <form class="admin-form" method="POST" action="<?= site_path() ?>/admin/usuarios/salvar.php">
        <input type="hidden" name="id" value="<?= $usuario ? $usuario->getId() : '' ?>">

        <div class="row g-4">
            <div class="col-md-6 form-group">
                <label class="form-label" for="email">E-mail</label>
                <input type="email" id="email" class="form-control" name="email" value="<?= htmlspecialchars($usuario ? $usuario->getEmail() : '') ?>" required>
            </div>

            <div class="col-md-6 form-group">
                <label class="form-label" for="senha">Senha<?= $usuario ? ' (deixe em branco para manter)' : '' ?></label>
                <input type="password" id="senha" class="form-control" name="senha" <?= $usuario ? '' : 'required' ?>>
            </div>

            <div class="col-12 mt-3 form-actions">
                <button class="btn btn-gold px-5" type="submit">
                    <i class="bi bi-check-lg"></i>
                    Salvar
                </button>
                <a href="<?= site_path() ?>/admin/usuarios/" class="btn btn-voltar px-4">Voltar</a>
            </div>
        </div>
    </form>
</div>
