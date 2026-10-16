<?php

require_once "conexao.php";
require_once __DIR__ . '/admin/veiculos/VeiculoRepository.php';
require_once __DIR__ . '/includes/vehicle_description.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: " . site_path() . "/");
    exit;
}


/*
|--------------------------------------------------------------------------
| VEÍCULO
|--------------------------------------------------------------------------
*/

$veiculoRepository = new VeiculoRepository($pdo);
$veiculo = $veiculoRepository->buscarPorId($id);


if (!$veiculo) {

    header("Location: " . site_path() . "/");
    exit;
}


/*
|--------------------------------------------------------------------------
| OPCIONAIS DO VEÍCULO
|--------------------------------------------------------------------------
*/

$opcionais = $veiculoRepository->listarOpcionais($id);
$imagensVeiculo = array_values(array_unique(array_filter(array_merge(
    $veiculo->getImagemPrincipal() ? [$veiculo->getImagemPrincipal()] : [],
    $veiculoRepository->listarImagens($id)
))));
$valorEssencial = number_format($veiculo->getValor(), 2, ',', '.');
$valorPremium = number_format($veiculo->getValorPremium() ?? $veiculo->getValor(), 2, ',', '.');
[$valorEssencialInteiro, $valorEssencialCentavos] = explode(',', $valorEssencial);
[$valorPremiumInteiro, $valorPremiumCentavos] = explode(',', $valorPremium);

?>

<section class="detalhes-veiculo py-5">

    <div class="container">

        <!-- =====================================================
             VEÍCULO
        ====================================================== -->

        <div class="row g-5 align-items-start">


            <!-- IMAGEM -->

            <div class="col-lg-7">

                <div class="imagem-detalhes-veiculo">
                    <?php if (count($imagensVeiculo) > 1): ?>
                        <div id="veiculo-imagens-<?= $veiculo->getId() ?>" class="carousel slide" data-bs-interval="false">
                            <div class="carousel-inner">
                                <?php foreach ($imagensVeiculo as $indice => $imagem): ?>
                                    <div class="carousel-item <?= $indice === 0 ? 'active' : '' ?>">
                                        <img
                                            src="<?= htmlspecialchars($imagem) ?>"
                                            alt="<?= htmlspecialchars($veiculo->getMarca() . ' ' . $veiculo->getModelo()) ?> - Foto <?= $indice + 1 ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#veiculo-imagens-<?= $veiculo->getId() ?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Foto anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#veiculo-imagens-<?= $veiculo->getId() ?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Próxima foto</span>
                            </button>
                        </div>
                    <?php else: ?>
                        <img
                            src="<?= htmlspecialchars($imagensVeiculo[0] ?? 'img/carros/noimage.svg') ?>"
                            alt="<?= $imagensVeiculo ? htmlspecialchars($veiculo->getMarca() . ' ' . $veiculo->getModelo()) : 'Sem imagem' ?>">
                    <?php endif; ?>
                </div>

                <?php if (!empty($opcionais)): ?>
                    <div class="opcionais-veiculo mt-4 opcionais-quadro">
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
                                    <span><?= htmlspecialchars($opcional->getNome()) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($veiculo->getDescricao() !== ''): ?>
                    <section class="descricao-detalhes-veiculo mt-4">
                        <h2>Descrição do veículo</h2>
                        <div><?= vehicleDescriptionHtml($veiculo->getDescricao()) ?></div>
                    </section>
                <?php endif; ?>

            </div>


            <!-- INFORMAÇÕES -->

            <div class="col-lg-5">

                <div class="info-detalhes-veiculo">

                    <?php if ($veiculo->isNovo()): ?>
                        <span class="badge-novidade">Novidade</span>

                    <?php endif; ?>

                    <hr>
                    <span class="marca-detalhes">

                        <?= htmlspecialchars($veiculo->getMarca()) ?>

                    </span>


                    <h1>

                        <?= htmlspecialchars($veiculo->getModelo()) ?>

                    </h1>
                    <hr>


                    <div class="planos-veiculo">
                        <div class="plano-veiculo plano-essencial">
                            <h2 class="plano-titulo">Faustino<br>Essencial</h2>
                            <p class="plano-subtitulo">O melhor preço para sair<br>de carro novo.</p>
                            <div class="plano-preco"><small>R$</small><strong><?= $valorEssencialInteiro ?></strong><small>,<?= $valorEssencialCentavos ?></small></div>
                            <ul class="vantagens-plano">
                                <li><i class="bi bi-check-circle-fill"></i> Veículo revisado</li>
                                <li><i class="bi bi-check-circle-fill"></i> Documentação em dia</li>
                                <li><i class="bi bi-check-circle-fill"></i> Pronto para transferência</li>
                                <li><i class="bi bi-check-circle-fill"></i> Melhor custo-benefício</li>
                            </ul>
                            <div class="plano-observacao">Sem garantia da loja<br>Sem cobertura de motor/câmbio<br>Sem assistência pós-venda</div>
                        </div>
                        <div class="plano-veiculo plano-premium">
                            <h2 class="plano-titulo">Faustino<br>Premium</h2>
                            <p class="plano-subtitulo">Mais tranquilidade,<br>mais segurança.</p>
                            <div class="plano-preco"><small>R$</small><strong><?= $valorPremiumInteiro ?></strong><small>,<?= $valorPremiumCentavos ?></small></div>
                            <strong class="premium-intro">Tudo do Essencial, mais:</strong>
                            <ul class="vantagens-plano">
                                <li><i class="bi bi-check-circle-fill"></i> Garantia da loja</li>
                                <li><i class="bi bi-check-circle-fill"></i> Cobertura de motor e câmbio*</li>
                                <li><i class="bi bi-check-circle-fill"></i> Assistência pós-venda</li>
                                <li><i class="bi bi-check-circle-fill"></i> Benefícios exclusivos</li>
                            </ul>
                            <div class="plano-observacao"><strong>Garantia Faustino Motors</strong><br>Condições especiais — consulte<br>a loja.</div>
                        </div>
                    </div>


                    <!-- DADOS -->

                    <div class="dados-detalhes">


                        <div class="item-detalhe">

                            <i class="bi bi-calendar3"></i>

                            <div>

                                <span>Ano</span>

                                <strong>
                                    <?= htmlspecialchars((string) $veiculo->getAno()) ?>
                                </strong>

                            </div>

                        </div>


                        <div class="item-detalhe">

                            <i class="bi bi-speedometer2"></i>

                            <div>

                                <span>Quilometragem</span>

                                <strong>

                                    <?= number_format(
                                        $veiculo->getKm(),
                                        0,
                                        ",",
                                        "."
                                    ) ?>

                                    km

                                </strong>

                            </div>

                        </div>


                        <div class="item-detalhe">

                            <i class="bi bi-gear-fill"></i>

                            <div>

                                <span>Câmbio</span>

                                <strong>
                                    <?= htmlspecialchars($veiculo->getCambio()) ?>
                                </strong>

                            </div>

                        </div>


                        <div class="item-detalhe">

                            <i class="bi bi-fuel-pump-fill"></i>

                            <div>

                                <span>Combustível</span>

                                <strong>
                                    <?= htmlspecialchars($veiculo->getCombustivel()) ?>
                                </strong>

                            </div>

                        </div>


                    </div>


                    <!-- WHATSAPP -->

                    <a
                        href="https://wa.me/5514997533055?text=<?= urlencode(
                            "Olá! Venho pelo site e tenho interesse neste veículo.\n\n" .
                            "*Marca:* " . $veiculo->getMarca() . "\n" .
                            "*Modelo:* " . $veiculo->getModelo() . "\n" .
                            "*Ano:* " . $veiculo->getAno() . "\n" .
                            "*Quilometragem:* " . number_format($veiculo->getKm(), 0, ',', '.') . " km\n" .
                            "*Câmbio:* " . $veiculo->getCambio() . "\n" .
                            "*Combustível:* " . $veiculo->getCombustivel() . "\n" .
                            "*Faustino Essencial:* R$ " . $valorEssencial . "\n" .
                            "*Faustino Premium:* R$ " . $valorPremium
                        ) ?>"
                        target="_blank"
                        class="btn-interesse">

                        <i class="bi bi-whatsapp"></i>

                        Tenho interesse

                    </a>


                </div>

            </div>

        </div>


        <!-- VOLTAR -->

        <div class="mt-4">

            <a
                href="<?= site_path() ?>/"
                class="btn-voltar">

                <i class="bi bi-arrow-left"></i>

                Voltar para o estoque

            </a>

        </div>


    </div>

</section>