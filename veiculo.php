<?php

require_once "conexao.php";

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

    WHERE v.id = ?

    LIMIT 1
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

$veiculo = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$veiculo) {

    header("Location: index.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| OPCIONAIS DO VEÍCULO
|--------------------------------------------------------------------------
*/

$sqlOpcionais = "
    SELECT
        o.id,
        o.nome
    FROM veiculos_opcionais vo

    INNER JOIN opcionais o
        ON o.id = vo.id_opcionais

    WHERE vo.id_veiculo = ?

    ORDER BY o.nome ASC
";

$stmtOpcionais = $pdo->prepare($sqlOpcionais);
$stmtOpcionais->execute([$id]);

$opcionais = $stmtOpcionais->fetchAll(PDO::FETCH_ASSOC);

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

                    <?php if (!empty($veiculo['imagem_principal'])): ?>

                        <img
                            src="<?= htmlspecialchars($veiculo['imagem_principal']) ?>"
                            alt="<?= htmlspecialchars(
                                        $veiculo['marca'] . ' ' . $veiculo['modelo']
                                    ) ?>">

                    <?php else: ?>

                        <img
                            src="img/sem-imagem.jpg"
                            alt="Sem imagem">

                    <?php endif; ?>

                </div>

            </div>


            <!-- INFORMAÇÕES -->

            <div class="col-lg-5">

                <div class="info-detalhes-veiculo">


                    <span class="marca-detalhes">

                        <?= htmlspecialchars($veiculo['marca']) ?>

                    </span>


                    <h1>

                        <?= htmlspecialchars($veiculo['modelo']) ?>

                    </h1>


                    <div class="preco-detalhes">

                        R$

                        <?= number_format(
                            $veiculo['valor'],
                            2,
                            ",",
                            "."
                        ) ?>

                    </div>


                    <!-- DADOS -->

                    <div class="dados-detalhes">


                        <div class="item-detalhe">

                            <i class="bi bi-calendar3"></i>

                            <div>

                                <span>Ano</span>

                                <strong>
                                    <?= htmlspecialchars($veiculo['ano']) ?>
                                </strong>

                            </div>

                        </div>


                        <div class="item-detalhe">

                            <i class="bi bi-speedometer2"></i>

                            <div>

                                <span>Quilometragem</span>

                                <strong>

                                    <?= number_format(
                                        $veiculo['km'],
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
                                    <?= htmlspecialchars($veiculo['cambio']) ?>
                                </strong>

                            </div>

                        </div>


                        <div class="item-detalhe">

                            <i class="bi bi-fuel-pump-fill"></i>

                            <div>

                                <span>Combustível</span>

                                <strong>
                                    <?= htmlspecialchars($veiculo['combustivel']) ?>
                                </strong>

                            </div>

                        </div>


                    </div>


                    <!-- WHATSAPP -->

                    <a
                        href="https://wa.me/5514997533055?text=<?= urlencode(
                                                                    'Olá! Venho pelo site e tenho interesse no veículo ' .
                                                                        $veiculo['marca'] . ' ' .
                                                                        $veiculo['modelo'] . ' ' .
                                                                        $veiculo['ano']
                                                                ) ?>"
                        target="_blank"
                        class="btn-interesse">

                        <i class="bi bi-whatsapp"></i>

                        Tenho interesse

                    </a>


                </div>

            </div>

        </div>


        <!-- =====================================================
             OPCIONAIS
        ====================================================== -->

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
                                <?= htmlspecialchars($opcional['nome']) ?>
                            </span>

                        </div>

                    <?php endforeach; ?>

                </div>

            </div>

        <?php endif; ?>


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