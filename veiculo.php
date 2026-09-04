<?php

require_once "conexao.php";
require_once __DIR__ . '/admin/veiculos/VeiculoRepository.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: index.php");
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

    header("Location: index.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| OPCIONAIS DO VEÍCULO
|--------------------------------------------------------------------------
*/

$opcionais = $veiculoRepository->listarOpcionais($id);

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

                    <?php if (!empty($veiculo->getImagemPrincipal())): ?>

                        <img
                            src="<?= htmlspecialchars($veiculo->getImagemPrincipal()) ?>"
                            alt="<?= htmlspecialchars(
                                        $veiculo->getMarca() . ' ' . $veiculo->getModelo()
                                    ) ?>">

                    <?php else: ?>

                        <img
                            src="img/sem-imagem.jpg"
                            alt="Sem imagem">

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
                        <div class="plano-veiculo">
                            <span class="plano-titulo">Venda essencial</span>
                            <strong>R$ <?= number_format($veiculo->getValor(), 2, ",", ".") ?></strong>
                            <ul class="vantagens-plano">
                                <li><i class="bi bi-check-circle-fill"></i> Revisão básica</li>
                                <li><i class="bi bi-x-circle-fill indisponivel"></i> Garantia de 1 ano</li>
                                <li><i class="bi bi-x-circle-fill indisponivel"></i> Assistência 24 horas</li>
                            </ul>
                        </div>
                        <div class="plano-veiculo plano-premium">
                            <span class="plano-titulo">Venda premium</span>
                            <strong>R$ <?= number_format($veiculo->getValorPremium() ?? $veiculo->getValor(), 2, ",", ".") ?></strong>
                            <ul class="vantagens-plano">
                                <li><i class="bi bi-check-circle-fill"></i> Revisão básica</li>
                                <li><i class="bi bi-check-circle-fill"></i> Garantia de 1 ano</li>
                                <li><i class="bi bi-check-circle-fill"></i> Assistência 24 horas</li>
                            </ul>
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
                                                                    'Olá! Venho pelo site e tenho interesse no veículo ' .
                                                                        $veiculo->getMarca() . ' ' .
                                                                        $veiculo->getModelo() . ' ' .
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


        <!-- VOLTAR -->

        <div class="mt-4">

            <a
                href="index.php"
                class="btn-voltar">

                <i class="bi bi-arrow-left"></i>

                Voltar para o estoque

            </a>

        </div>


    </div>

</section>