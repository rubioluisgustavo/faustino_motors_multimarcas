<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";
require_once __DIR__ . '/VendaRepository.php';
require_once __DIR__ . '/../includes/head.php';

$repository = new VendaRepository($pdo);

if (isset($_GET['excluir'])) {
    $id = filter_input(INPUT_GET, 'excluir', FILTER_VALIDATE_INT);
    if ($id) {
        $repository->excluir($id);
    }
    header('Location: ' . site_path() . '/admin/vendas/');
    exit;
}

$vendas = $repository->listar();
?>

<link href="../css/admin.css" rel="stylesheet">
<link href="vendas.css" rel="stylesheet">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <h2 class="titulo-admin m-0">Vendidos</h2>
    <a href="<?= site_path() ?>/admin/vendas/cadastro.php" class="btn btn-adicionar d-inline-flex align-items-center justify-content-center gap-2">
        <i class="bi bi-plus-circle"></i>
        Adicionar venda
    </a>
    <a href="<?= site_path() ?>/admin/" class="btn btn-adicionar d-inline-flex align-items-center justify-content-center gap-2">
        <i class="bi bi-arrow-left-circle"></i>
        Voltar
    </a>
</div>

<div class="card-admin">
    <div class="table-responsive">
        <table class="table table-admin align-middle">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Depoimento</th>
                    <th>Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vendas as $venda): ?>
                    <tr>
                        <td>
                            <?php if ($venda->getImagemPrincipal()): ?>
                                <img src="../../<?= htmlspecialchars($venda->getImagemPrincipal()) ?>"
                                     alt="<?= htmlspecialchars($venda->getNome()) ?>"
                                     class="venda-imagem-admin">
                            <?php else: ?>
                                Sem imagem
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($venda->getNome()) ?></td>
                        <td class="venda-depoimento"><?= htmlspecialchars($venda->getDepoimento()) ?></td>
                        <td>
                            <a href="<?= site_path() ?>/admin/vendas/cadastro.php?id=<?= $venda->getId() ?>" class="btn btn-sm btn-editar">Editar</a>
                            <a href="<?= site_path() ?>/admin/vendas/?excluir=<?= $venda->getId() ?>"
                               class="btn btn-sm btn-excluir"
                               onclick="return confirm('Excluir venda?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
