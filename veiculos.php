<?php

require_once "conexao.php";


// filtros recebidos

$marca  = $_GET['marca'] ?? '';
$modelo = $_GET['modelo'] ?? '';
$ano    = $_GET['ano'] ?? '';



$sql = "

SELECT

    v.id,
    ma.nome AS marca,
    mo.nome AS modelo,
    v.ano,
    v.km,
    v.cambio,
    v.combustivel,
    v.valor,
    v.imagem_principal


FROM veiculos v


INNER JOIN modelos mo
    ON mo.id = v.id_modelo


INNER JOIN marcas ma
    ON ma.id = mo.id_marca


WHERE 1=1

";


$params = [];



if ($marca != '') {

    $sql .= " AND ma.id = ? ";

    $params[] = $marca;
}



if ($modelo != '') {

    $sql .= " AND mo.id = ? ";

    $params[] = $modelo;
}



if ($ano != '') {

    $sql .= " AND v.ano = ? ";

    $params[] = $ano;
}



$sql .= " ORDER BY v.id DESC ";



$stmt = $pdo->prepare($sql);


$stmt->execute($params);


$veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<section class="estoque py-5">

    <div class="container">

        <div class="row g-4">


            <?php foreach ($veiculos as $veiculo): ?>


                <div class="col-lg-4 col-md-6">

                    <div class="card card-veiculo h-100">

                        <div class="imagem-veiculo">

                            <a href="index.php?id=<?= $veiculo['id'] ?>">

                                <?php if (!empty($veiculo['imagem_principal'])): ?>

                                    <img
                                        src="<?= htmlspecialchars($veiculo['imagem_principal']) ?>"
                                        class="card-img-top"
                                        alt="<?= htmlspecialchars($veiculo['marca'] . ' ' . $veiculo['modelo']) ?>">

                                <?php else: ?>

                                    <img
                                        src="img/sem-imagem.jpg"
                                        class="card-img-top"
                                        alt="Sem imagem">

                                <?php endif; ?>

                            </a>

                        </div>


                        <div class="card-body">

                            <div class="dados-veiculo">

                                <div class="identificacao-veiculo">

                                    <h4 class="marca">
                                        <?= htmlspecialchars($veiculo['marca']) ?>
                                    </h4>

                                    <h5 class="modelo">
                                        <?= htmlspecialchars($veiculo['modelo']) ?>
                                    </h5>

                                </div>


                                <div class="info-veiculo">

                                    <div class="item-info">

                                        <i class="bi bi-calendar3"></i>

                                        <?= $veiculo['ano'] ?>

                                    </div>


                                    <div class="item-info">

                                        <i class="bi bi-speedometer2"></i>

                                        <?= number_format($veiculo['km'], 0, ",", ".") ?>

                                    </div>


                                    <div class="item-info">

                                        <i class="bi bi-gear-fill"></i>

                                        <?= htmlspecialchars($veiculo['cambio']) ?>

                                    </div>


                                    <div class="item-info">

                                        <i class="bi bi-fuel-pump-fill"></i>

                                        <?= htmlspecialchars($veiculo['combustivel']) ?>

                                    </div>

                                </div>

                            </div>


                            <div class="acoes-veiculo">

                                <div class="valor">

                                    R$ <?= number_format($veiculo['valor'], 2, ",", ".") ?>

                                </div>


                                <a
                                    href="index.php?id=<?= $veiculo['id'] ?>"
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