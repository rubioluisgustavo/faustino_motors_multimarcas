<link href="../veiculos/veiculos.css" rel="stylesheet">
<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";
require_once __DIR__ . '/VeiculoRepository.php';
require_once __DIR__ . '/../modelos/ModeloRepository.php';
require_once __DIR__ . '/../opcionais/OpcionalRepository.php';
require_once __DIR__ . '/../includes/head.php';



// =============================
// ID DO VEÍCULO
// =============================

$id = isset($_GET['id']) ? (int) $_GET['id'] : null;


// =============================
// DADOS PADRÃO DO VEÍCULO
// =============================

$veiculo = new Veiculo();


// =============================
// OPCIONAIS SELECIONADOS
// =============================

$opcionaisSelecionados = [];


// =============================
// BUSCA VEÍCULO PARA EDIÇÃO
// =============================

if ($id) {

    $veiculoEncontrado = (new VeiculoRepository($pdo))->buscarPorId($id);
    if ($veiculoEncontrado) {
        $veiculo = $veiculoEncontrado;
    }


    // =============================
    // BUSCA OPCIONAIS DO VEÍCULO
    // =============================

    $sql = $pdo->prepare("

        SELECT id_opcionais

        FROM veiculos_opcionais

        WHERE id_veiculo = ?

    ");

    $sql->execute([$id]);


    $opcionaisSelecionados = $sql->fetchAll(
        PDO::FETCH_COLUMN
    );
}


// =============================
// FORMATA VALOR
// =============================

$valor = '';

if ($veiculo->getValor() > 0) {

    $valor = number_format(
        $veiculo->getValor(),
        2,
        ",",
        "."
    );
}

$valorPremium = '';
if ($veiculo->getValorPremium() !== null) {
    $valorPremium = number_format($veiculo->getValorPremium(), 2, ",", ".");
}


// =============================
// BUSCA MODELOS
// =============================

$modelos = (new ModeloRepository($pdo))->listar();


// =============================
// BUSCA OPCIONAIS
// =============================

$opcionais = (new OpcionalRepository($pdo))->listar();


?>

<link href="../css/admin.css" rel="stylesheet">
<div class="card-admin">

    <form
        method="POST"
        action="<?= site_path() ?>/admin/veiculos/salvar.php"
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

                            value="<?= $m->getId() ?>"

                            <?= $m->getId() == $veiculo->getIdModelo() ? 'selected' : '' ?>>

                            <?= htmlspecialchars($m->getMarca() . ' - ' . $m->getNome()) ?>


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
                    value="<?= $veiculo->getAno() ?: '' ?>">


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
                    value="<?= $veiculo->getKm() ?: '' ?>">


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


                    <option value="manual" <?= $veiculo->getCambio() == "manual" ? 'selected' : '' ?>>
                        manual
                    </option>

                    <option value="automático" <?= $veiculo->getCambio() == "automatico" ? 'selected' : '' ?>>
                        automático
                    </option>


                </select>


            </div>

            <div class="col-md-4">
                <label class="form-label">Valor premium</label>
                <input
                    type="text"
                    class="form-control"
                    name="valor_premium"
                    value="<?= htmlspecialchars($valorPremium) ?>"
                    placeholder="Opcional">
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


                    <option value="flex" <?= $veiculo->getCombustivel() == "flex" ? 'selected' : '' ?>>
                        flex
                    </option>

                    <option value="gasolina" <?= $veiculo->getCombustivel() == "gasolina" ? 'selected' : '' ?>>
                        gasolina
                    </option>

                    <option value="etanol" <?= $veiculo->getCombustivel() == "etanol" ? 'selected' : '' ?>>
                        etanol
                    </option>

                    <option value="diesel" <?= $veiculo->getCombustivel() == "diesel" ? 'selected' : '' ?>>
                        diesel
                    </option>

                    <option value="eletrico" <?= $veiculo->getCombustivel() == "eletrico" ? 'selected' : '' ?>>
                        elétrico
                    </option>

                    <option value="hibrido" <?= $veiculo->getCombustivel() == "hibrido" ? 'selected' : '' ?>>
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


                <?php if (!empty($veiculo->getImagemPrincipal())): ?>


                    <label class="form-label">
                        Imagem atual
                    </label>


                    <div class="preview-imagem">


                        <img
                            src="../../<?= htmlspecialchars($veiculo->getImagemPrincipal()) ?>"
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
                    name="descricao"><?= htmlspecialchars($veiculo->getDescricao()) ?></textarea>


            </div>

            <div class="col-12">

                <label class="form-label">
                    Opcionais
                </label>

                <div class="opcionais-container">

                    <?php foreach ($opcionais as $opcional): ?>

                        <div class="form-check form-check-inline opcional-item">

                            <input
                                type="checkbox"
                                class="form-check-input"
                                name="opcionais[]"
                                value="<?= $opcional->getId() ?>"
                                id="opcional_<?= $opcional->getId() ?>"

                                <?=
                                in_array(
                                    $opcional->getId(),
                                    $opcionaisSelecionados ?? []
                                )
                                    ? 'checked'
                                    : ''
                                ?>>

                            <label
                                class="form-check-label text-gold"
                                for="opcional_<?= $opcional->getId() ?>">

                                <?= htmlspecialchars($opcional->getNome()) ?>

                            </label>

                        </div>

                    <?php endforeach; ?>

                </div>

            </div>

            <!-- Marcar como novo -->
            <div class="col-12">
                <div class="marcar-novo-container">

                    <input
                        type="checkbox"
                        class="marcar-novo-checkbox"
                        id="marcar_novo"
                        name="novo"
                        value="y"
                        <?= $veiculo->isNovo() ? 'checked' : '' ?>>

                    <label
                        for="marcar_novo"
                        class="marcar-novo-label">

                        <span class="marcar-novo-check">
                            <i class="bi bi-check-lg"></i>
                        </span>

                        <span class="marcar-novo-texto">
                            <strong>Marcar como novo</strong>
                            <small>Exibir este veículo com o selo "Novo"</small>
                        </span>

                    </label>

                </div>
            </div>



            <!-- BotÃÂµes -->
            <div class="col-12 mt-3">


                <button
                    class="btn btn-gold px-5">

                    <i class="bi bi-check-lg"></i>
                    Salvar


                </button>



                <a
                    href="<?= site_path() ?>/admin/veiculos/"
                    class="btn btn-voltar px-4">

                    Voltar

                </a>


            </div>



        </div>


    </form>

</div>