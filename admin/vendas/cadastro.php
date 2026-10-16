<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";
require_once __DIR__ . '/VendaRepository.php';
require_once __DIR__ . '/../includes/head.php';

$repository = new VendaRepository($pdo);
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
$venda = $id ? $repository->buscarPorId($id) : new Venda();
?>

<link href="../css/admin.css" rel="stylesheet">

<div class="card-admin">
    <form class="admin-form" method="POST" action="<?= site_path() ?>/admin/vendas/salvar.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $venda->getId() ?? '' ?>">

        <div class="row g-4">
            <div class="col-md-6 form-group">
                <label class="form-label">Nome do cliente</label>
                <input type="text" class="form-control" name="nome"
                       value="<?= htmlspecialchars($venda->getNome()) ?>" required>
            </div>

            <div class="col-md-6 form-group">
                <label class="form-label">Foto principal</label>
                <input type="file" class="form-control" name="imagem_principal" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                <?php if ($venda->getImagemPrincipal()): ?>
                    <img src="../../<?= htmlspecialchars($venda->getImagemPrincipal()) ?>"
                         alt="Imagem atual" class="img-fluid mt-2" style="max-height: 160px">
                <?php endif; ?>
            </div>

            <div class="col-md-6 form-group">
                <label class="form-label" for="imagens-venda">Fotos adicionais para o carrossel</label>
                <input
                    type="file"
                    id="imagens-venda"
                    class="form-control"
                    name="imagens[]"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    multiple>
                <small class="form-text text-light">Selecione uma ou mais fotos para adicionar à galeria.</small>
                <?php if ($venda->getImagens()): ?>
                    <div class="preview-galeria-venda mt-2">
                        <?php foreach ($venda->getImagens() as $imagemAtual): ?>
                            <img src="../../<?= htmlspecialchars($imagemAtual) ?>" alt="Foto atual da venda">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-12 form-group">
                <label class="form-label">Depoimento</label>
                <textarea class="form-control" name="depoimento" rows="5"><?= htmlspecialchars($venda->getDepoimento()) ?></textarea>
            </div>

            <div class="col-12 mt-3 form-actions">
                <button class="btn btn-gold px-5">Salvar</button>
                <a href="<?= site_path() ?>/admin/vendas/" class="btn btn-voltar px-4">Voltar</a>
            </div>
        </div>
    </form>
</div>
