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
    <form method="POST" action="salvar.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $venda->getId() ?? '' ?>">

        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label">Nome do cliente</label>
                <input type="text" class="form-control" name="nome"
                       value="<?= htmlspecialchars($venda->getNome()) ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Imagem principal</label>
                <input type="file" class="form-control" name="imagem_principal" accept="image/*">
                <?php if ($venda->getImagemPrincipal()): ?>
                    <img src="../../<?= htmlspecialchars($venda->getImagemPrincipal()) ?>"
                         alt="Imagem atual" class="img-fluid mt-2" style="max-height: 160px">
                <?php endif; ?>
            </div>

            <div class="col-12">
                <label class="form-label">Depoimento</label>
                <textarea class="form-control" name="depoimento" rows="5"><?= htmlspecialchars($venda->getDepoimento()) ?></textarea>
            </div>

            <div class="col-12">
                <button class="btn btn-gold px-5">Salvar</button>
                <a href="index.php" class="btn btn-voltar px-4">Voltar</a>
            </div>
        </div>
    </form>
</div>
