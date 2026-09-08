<?php

require_once "conexao.php";
require_once __DIR__ . '/admin/veiculos/VeiculoRepository.php';


// filtros recebidos

$marca  = $_GET['marca'] ?? '';
$modelo = $_GET['modelo'] ?? '';
$ano    = $_GET['ano'] ?? '';



$veiculos = (new VeiculoRepository($pdo))->listar([
    'marca' => $marca,
    'modelo' => $modelo,
    'ano' => $ano,
]);


?>

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

                            <a href="<?= site_path() ?>/?id=<?= $veiculo->getId() ?>">

                                <?php if (!empty($veiculo->getImagemPrincipal())): ?>

                                    <img
                                        src="<?= htmlspecialchars($veiculo->getImagemPrincipal()) ?>"
                                        class="card-img-top"
                                        alt="<?= htmlspecialchars($veiculo->getMarca() . ' ' . $veiculo->getModelo()) ?>">

                                <?php else: ?>

                                    <img
                                        src="img/carros/noimage.svg"
                                        class="card-img-top"
                                        alt="Sem imagem">

                                <?php endif; ?>

                            </a>

                        </div>


                        <div class="card-body">

                            <div class="dados-veiculo">

                                <div class="identificacao-veiculo">

                                    <h4 class="marca">
                                        <?= htmlspecialchars($veiculo->getMarca()) ?>
                                    </h4>

                                    <h5 class="modelo">
                                        <?= htmlspecialchars($veiculo->getModelo()) ?>
                                    </h5>

                                </div>


                                <div class="info-veiculo">

                                    <div class="item-info">

                                        <i class="bi bi-calendar3"></i>

                                        <?= $veiculo->getAno() ?>

                                    </div>


                                    <div class="item-info">

                                        <i class="bi bi-speedometer2"></i>

                                        <?= number_format($veiculo->getKm(), 0, ",", ".") ?>

                                    </div>


                                    <div class="item-info">

                                        <i class="bi bi-gear-fill"></i>

                                        <?= htmlspecialchars($veiculo->getCambio()) ?>

                                    </div>


                                    <div class="item-info">

                                        <i class="bi bi-fuel-pump-fill"></i>

                                        <?= htmlspecialchars($veiculo->getCombustivel()) ?>

                                    </div>

                                </div>

                            </div>


                            <div class="acoes-veiculo">

                                <div class="valor">

                                    R$ <?= number_format($veiculo->getValor(), 2, ",", ".") ?>

                                </div>


                                <a
                                    href="<?= site_path() ?>/?id=<?= $veiculo->getId() ?>"
                                    class="btn-saiba-mais">

                                    Saiba mais

                                </a>

                            </div>

                        </div>


                    </div>

                </div>


            <?php endforeach; ?>

            <?php if (count($veiculos) == 0): ?>

                <div class="alert alert-warning">
                    Nenhum veículo encontrado.
                </div>

            <?php endif; ?>


        </div>

    </div>

</section>