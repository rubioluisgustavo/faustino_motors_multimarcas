<?php

require_once "../../conexao.php";

$id = $_GET['id'] ?? null;


$veiculo = [

    'id_modelo' => '',
    'ano' => '',
    'km' => '',
    'cambio' => '',
    'combustivel' => '',
    'valor' => '',
    'imagem_principal' => '',
    'descricao' => ''

];


if ($id) {

    $sql = $pdo->prepare("
        SELECT *
        FROM veiculos
        WHERE id=?
    ");

    $sql->execute([$id]);

    $veiculo = $sql->fetch();
}


// FORMATA VALOR
$valor = '';

if (!empty($veiculo['valor'])) {

    $valor = number_format(
        $veiculo['valor'],
        2,
        ",",
        "."
    );
}


$id = $_GET['id'] ?? null;


$veiculo = [

    'id_modelo' => '',
    'ano' => '',
    'km' => '',
    'cambio' => '',
    'combustivel' => '',
    'valor' => '',
    'imagem_principal' => '',
    'descricao' => ''

];



if ($id) {


    $sql = $pdo->prepare("
SELECT *
FROM veiculos
WHERE id=?
");


    $sql->execute([$id]);


    $veiculo = $sql->fetch();
}



$modelos = $pdo->query("

SELECT

mo.id,
CONCAT(ma.nome,' - ',mo.nome) AS nome


FROM modelos mo


INNER JOIN marcas ma
ON ma.id=mo.id_marca


ORDER BY ma.nome,mo.nome


")->fetchAll();



?>

<link href="../css/admin.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

<div class="card-admin">

    <form
        method="POST"
        action="salvar.php"
        enctype="multipart/form-data">


        <input
            type="hidden"
            name="id"
            value="<?= $id ?>">



        <div class="row g-4">



            <!-- Modelo -->
            <div class="col-md-6">


                <label class="form-label">
                    Modelo
                </label>


                <select
                    name="id_modelo"
                    class="form-select">

                    <option value="">
                        Selecione o modelo
                    </option>


                    <?php foreach ($modelos as $m): ?>


                        <option

                            value="<?= $m['id'] ?>"

                            <?= $m['id'] == $veiculo['id_modelo'] ? 'selected' : '' ?>>

                            <?= htmlspecialchars($m['nome']) ?>


                        </option>


                    <?php endforeach; ?>


                </select>


            </div>





            <!-- Ano -->
            <div class="col-md-3">


                <label class="form-label">
                    Ano
                </label>


                <input
                    type="number"
                    class="form-control"
                    name="ano"
                    value="<?= $veiculo['ano'] ?? '' ?>">


            </div>





            <!-- KM -->
            <div class="col-md-3">


                <label class="form-label">
                    KM
                </label>


                <input
                    type="number"
                    class="form-control"
                    name="km"
                    value="<?= $veiculo['km'] ?? '' ?>">


            </div>





            <!-- CÃÂ¢mbio -->
            <div class="col-md-4">


                <label class="form-label">
                    Câmbio
                </label>


                <select
                    name="cambio"
                    class="form-select">

                    <option value="">
                        Selecione o câmbio
                    </option>


                    <option value="manual" <?= $veiculo['cambio'] == "manual" ? 'selected' : '' ?>>
                        manual
                    </option>

                    <option value="automático" <?= $veiculo['cambio'] == "automatico" ? 'selected' : '' ?>>
                        automático
                    </option>


                </select>


            </div>





            <!-- CombustÃÂ­vel -->
            <div class="col-md-4">


                <label class="form-label">
                    Combustível
                </label>


                <select
                    name="combustivel"
                    class="form-select">

                    <option value="">
                        Selecione o combustível
                    </option>


                    <option value="flex" <?= $veiculo['combustivel'] == "flex" ? 'selected' : '' ?>>
                        flex
                    </option>

                    <option value="gasolina" <?= $veiculo['combustivel'] == "gasolina" ? 'selected' : '' ?>>
                        gasolina
                    </option>

                    <option value="etanol" <?= $veiculo['combustivel'] == "etanol" ? 'selected' : '' ?>>
                        etanol
                    </option>

                    <option value="diesel" <?= $veiculo['combustivel'] == "diesel" ? 'selected' : '' ?>>
                        diesel
                    </option>

                    <option value="eletrico" <?= $veiculo['combustivel'] == "hibrido" ? 'selected' : '' ?>>
                        elétrico
                    </option>

                    <option value="hibrido" <?= $veiculo['combustivel'] == "hibrido" ? 'selected' : '' ?>>
                        híbrido
                    </option>


                </select>


            </div>





            <!-- Valor -->
            <div class="col-md-4">


                <label class="form-label">
                    Valor
                </label>


                <input
                    type="text"
                    class="form-control"
                    name="valor"
                    value="<?= $valor ?>">


            </div>





            <!-- Imagem -->
            <div class="col-md-6">


                <label class="form-label">
                    Foto principal
                </label>


                <input
                    type="file"
                    class="form-control"
                    name="imagem_principal"
                    accept="image/*">


            </div>





            <!-- Preview -->
            <div class="col-md-6">


                <?php if (!empty($veiculo['imagem_principal'])): ?>


                    <label class="form-label">
                        Imagem atual
                    </label>


                    <div class="preview-imagem">


                        <img
                            src="../../<?= $veiculo['imagem_principal'] ?>"
                            class="img-fluid">


                    </div>


                <?php endif; ?>


            </div>





            <!-- DescriÃÂ§ÃÂ£o -->
            <div class="col-12">


                <label class="form-label">
                    Descrição
                </label>


                <textarea
                    class="form-control"
                    rows="5"
                    name="descricao"><?= $veiculo['descricao'] ?? '' ?></textarea>


            </div>





            <!-- BotÃÂµes -->
            <div class="col-12 mt-3">


                <button
                    class="btn btn-gold px-5">

                    <i class="bi bi-check-lg"></i>
                    Salvar


                </button>



                <a
                    href="index.php"
                    class="btn btn-voltar px-4">

                    Voltar

                </a>


            </div>



        </div>


    </form>

</div>