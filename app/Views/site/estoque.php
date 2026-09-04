<section class="estoque py-5">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($veiculos as $veiculo): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card card-veiculo h-100">
                        <div class="imagem-veiculo">
                            <?php if ($veiculo->isNovo()): ?>
                                <div class="tarja-novo">
                                    NOVIDADE
                                </div>
                            <?php endif; ?>

                            <a href="<?= url('veiculo/' . $veiculo->getId()) ?>">
                                <?php if (!empty($veiculo->getImagemPrincipal())): ?>
                                    <img
                                        src="<?= asset($veiculo->getImagemPrincipal()) ?>"
                                        class="card-img-top"
                                        alt="<?= e($veiculo->getNomeCompleto()) ?>">
                                <?php else: ?>
                                    <img
                                        src="<?= asset('public/img/carros/noimage.svg') ?>"
                                        class="card-img-top"
                                        alt="Sem imagem">
                                <?php endif; ?>
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="dados-veiculo">
                                <div class="identificacao-veiculo">
                                    <h4 class="marca">
                                        <?= e($veiculo->getMarcaNome()) ?>
                                    </h4>

                                    <h5 class="modelo">
                                        <?= e($veiculo->getModeloNome()) ?>
                                    </h5>
                                </div>

                                <div class="info-veiculo">
                                    <div class="item-info">
                                        <i class="bi bi-calendar3"></i>
                                        <?= e($veiculo->getAno()) ?>
                                    </div>

                                    <div class="item-info">
                                        <i class="bi bi-speedometer2"></i>
                                        <?= numero($veiculo->getKm()) ?>
                                    </div>

                                    <div class="item-info">
                                        <i class="bi bi-gear-fill"></i>
                                        <?= e($veiculo->getCambio()) ?>
                                    </div>

                                    <div class="item-info">
                                        <i class="bi bi-fuel-pump-fill"></i>
                                        <?= e($veiculo->getCombustivel()) ?>
                                    </div>
                                </div>
                            </div>

                            <div class="acoes-veiculo">
                                <div class="valor">
                                    <?= dinheiro($veiculo->getValor()) ?>
                                </div>

                                <a
                                    href="<?= url('veiculo/' . $veiculo->getId()) ?>"
                                    class="btn-saiba-mais">
                                    Saiba mais
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (count($veiculos) === 0): ?>
                <div class="alert alert-warning">
                    Nenhum veículo encontrado.
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
