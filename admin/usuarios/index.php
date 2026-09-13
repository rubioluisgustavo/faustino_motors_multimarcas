<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";
require_once __DIR__ . '/UsuarioRepository.php';
require_once __DIR__ . '/../includes/head.php';

$usuarioRepository = new UsuarioRepository($pdo);
$podeGerenciar = usuarioPodeGerenciarUsuarios();

if (isset($_GET['excluir'])) {
    exigirPermissaoGerenciarUsuarios();
    $usuarioRepository->excluir((int) $_GET['excluir']);
    header('Location: ' . site_path() . '/admin/usuarios/');
    exit;
}

$usuarios = $usuarioRepository->listar();
$erro = $_GET['erro'] ?? null;
?>

<link href="../marcas/marcas.css" rel="stylesheet">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <h2 class="titulo-admin m-0">Usuários</h2>

    <?php if ($podeGerenciar): ?>
        <a href="<?= site_path() ?>/admin/usuarios/cadastro.php" class="btn btn-adicionar">
            <i class="bi bi-plus-circle"></i>
            Adicionar usuário
        </a>
    <?php endif; ?>

    <a href="<?= site_path() ?>/admin/" class="btn btn-adicionar">
        <i class="bi bi-arrow-left-circle"></i>
        Voltar
    </a>
</div>

<?php if ($erro): ?>
    <div class="alert alert-warning"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<div class="card-admin">
    <div class="table-responsive">
        <table class="table table-admin align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>E-mail</th>
                    <th>Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= htmlspecialchars((string) $usuario->getId()) ?></td>
                        <td><?= htmlspecialchars($usuario->getEmail()) ?></td>
                        <td>
                            <?php if ($podeGerenciar): ?>
                                <a href="<?= site_path() ?>/admin/usuarios/cadastro.php?id=<?= $usuario->getId() ?>" class="btn btn-sm btn-editar">Editar</a>
                                <a href="<?= site_path() ?>/admin/usuarios/?excluir=<?= $usuario->getId() ?>" class="btn btn-sm btn-excluir" onclick="return confirm('Excluir usuário?')">Excluir</a>
                            <?php else: ?>
                                <span class="text-light">Somente visualização</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
