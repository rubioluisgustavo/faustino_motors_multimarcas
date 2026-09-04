<section class="detalhes-veiculo py-5">
    <div class="container">
        <div class="row g-5 align-items-start">
            <div class="col-lg-7">
                <div class="imagem-detalhes-veiculo">
                    <?php if (!empty($veiculo->getImagemPrincipal())): ?>
                        <img
                            src="<?= asset($veiculo->getImagemPrincipal()) ?>"
                            alt="<?= e($veiculo->getNomeCompleto()) ?>">
                    <?php else: ?>
                        <img src="<?= asset('public/img/carros/noimage.svg') ?>" alt="Sem imagem">
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="info-detalhes-veiculo">
                    <?php if ($veiculo->isNovo()): ?>
                        <span class="badge-novidade">Novidade</span>
                    <?php endif; ?>

                    <hr>
                    <span class="marca-detalhes">
                        <?= e($veiculo->getMarcaNome()) ?>
                    </span>

                    <h1>
                        <?= e($veiculo->getModeloNome()) ?>
                    </h1>

                    <div class="preco-detalhes">
                        <?= dinheiro($veiculo->getValor()) ?>
                    </div>

                    <div class="dados-detalhes">
                        <div class="item-detalhe">
                            <i class="bi bi-calendar3"></i>

                            <div>
                                <span>Ano</span>

                                <strong>
                                    <?= e($veiculo->getAno()) ?>
                                </strong>
                            </div>
                        </div>

                        <div class="item-detalhe">
                            <i class="bi bi-speedometer2"></i>

                            <div>
                                <span>Quilometragem</span>

                                <strong>
                                    <?= numero($veiculo->getKm()) ?>
                                    km
                                </strong>
                            </div>
                        </div>

                        <div class="item-detalhe">
                            <i class="bi bi-gear-fill"></i>

                            <div>
                                <span>Câmbio</span>

                                <strong>
                                    <?= e($veiculo->getCambio()) ?>
                                </strong>
                            </div>
                        </div>

                        <div class="item-detalhe">
                            <i class="bi bi-fuel-pump-fill"></i>

                            <div>
                                <span>Combustível</span>

                                <strong>
                                    <?= e($veiculo->getCombustivel()) ?>
                                </strong>
                            </div>
                        </div>
                    </div>

                    <a
                        href="https://wa.me/5514997533055?text=<?= urlencode(
                            'Olá! Venho pelo site e tenho interesse no veículo ' .
                            $veiculo->getMarcaNome() . ' ' .
                            $veiculo->getModeloNome() . ' ' .
                            $veiculo->getAno()
                        ) ?>"
                        target="_blank"
                        class="btn-interesse">
                        <i class="bi bi-whatsapp"></i>
                        Tenho interesse
                    </a>
                </div>
            </div>
        </div>

        <?php if (!empty($opcionais)): ?>
            <div class="opcionais-veiculo mt-5">
                <div class="opcionais-header">
                    <h2>
                        <i class="bi bi-check-circle-fill"></i>
                        Opcionais
                    </h2>
                </div>

                <div class="lista-opcionais">
                    <?php foreach ($opcionais as $opcional): ?>
                        <div class="opcional-item">
                            <i class="bi bi-check-lg"></i>

                            <span>
                                <?= e($opcional->getNome()) ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="mt-4">
            <a href="<?= url() ?>" class="btn-voltar">
                <i class="bi bi-arrow-left"></i>
                Voltar para o estoque
            </a>
        </div>
    </div>
</section>
