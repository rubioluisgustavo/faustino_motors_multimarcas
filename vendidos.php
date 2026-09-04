<?php

require_once __DIR__ . '/conexao.php';
require_once __DIR__ . '/admin/vendas/VendaRepository.php';

$vendas = (new VendaRepository($pdo))->listar();
?>

<section class="vendidos py-5" id="vendidos">
    <div class="container">
        <div class="titulo-secao">
            <h2>Veículos vendidos</h2>
            <p>Histórias de clientes que confiaram na Faustino Motors.</p>
        </div>

        <?php if ($vendas): ?>
            <div class="row g-4">
                <?php foreach ($vendas as $venda): ?>
                    <div class="col-lg-4 col-md-6">
                        <article class="card card-vendido h-100">
                            <?php if ($venda->getImagemPrincipal()): ?>
                                <img src="<?= htmlspecialchars($venda->getImagemPrincipal()) ?>"
                                     class="card-img-top"
                                     alt="Venda para <?= htmlspecialchars($venda->getNome()) ?>">
                            <?php else: ?>
                                <img src="img/carros/noimage.svg"
                                     class="card-img-top"
                                     alt="Sem imagem">
                            <?php endif; ?>

                            <div class="card-body">
                                <h3><?= htmlspecialchars($venda->getNome()) ?></h3>
                                <?php if ($venda->getDepoimento()): ?>
                                    <blockquote>
                                        “<?= htmlspecialchars($venda->getDepoimento()) ?>”
                                    </blockquote>
                                <?php endif; ?>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">Nenhuma venda cadastrada.</div>
        <?php endif; ?>
    </div>
</section>
