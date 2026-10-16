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
                            <?php
                            $imagensVenda = array_values(array_unique(array_filter(array_merge(
                                $venda->getImagemPrincipal() ? [$venda->getImagemPrincipal()] : [],
                                $venda->getImagens()
                            ))));
                            ?>
                            <?php if (count($imagensVenda) > 1): ?>
                                <div id="venda-imagens-<?= $venda->getId() ?>" class="carousel slide" data-bs-interval="false">
                                    <div class="carousel-inner">
                                        <?php foreach ($imagensVenda as $indice => $imagem): ?>
                                            <div class="carousel-item <?= $indice === 0 ? 'active' : '' ?>">
                                                <img src="<?= htmlspecialchars($imagem) ?>"
                                                     class="card-img-top"
                                                     alt="Venda para <?= htmlspecialchars($venda->getNome()) ?> - Foto <?= $indice + 1 ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#venda-imagens-<?= $venda->getId() ?>" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Foto anterior</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#venda-imagens-<?= $venda->getId() ?>" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Próxima foto</span>
                                    </button>
                                </div>
                            <?php elseif ($imagensVenda): ?>
                                <img src="<?= htmlspecialchars($imagensVenda[0]) ?>"
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
