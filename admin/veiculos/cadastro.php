<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../../app/bootstrap.php';

$veiculoRepository = new App\Repositories\VeiculoRepository($pdo);
$modeloRepository = new App\Repositories\ModeloRepository($pdo);
$opcionalRepository = new App\Repositories\OpcionalRepository($pdo);

$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
$veiculo = new App\Models\Veiculo();
$opcionaisSelecionados = [];

if ($id) {
    $veiculoExistente = $veiculoRepository->buscarPorId($id);

    if ($veiculoExistente) {
        $veiculo = $veiculoExistente;
    }

    $opcionaisSelecionados = $opcionalRepository->listarIdsPorVeiculo($id);
}

$valor = $veiculo->getValor() > 0
    ? number_format($veiculo->getValor(), 2, ',', '.')
    : '';

$modelos = $modeloRepository->listar();
$opcionais = $opcionalRepository->listar();
?>

<link href="../css/admin.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

<div class="card-admin">
    <form method="POST" action="salvar.php" enctype="multipart/form-data">
        <input
            type="hidden"
            name="id"
            value="<?= $veiculo->getId() ?? '' ?>">

        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label">
                    Modelo
                </label>

                <select name="id_modelo" class="form-select">
                    <option value="">
                        Selecione o modelo
                    </option>

                    <?php foreach ($modelos as $modelo): ?>
                        <option
                            value="<?= $modelo->getId() ?>"
                            <?= $modelo->getId() == $veiculo->getIdModelo() ? 'selected' : '' ?>>
                            <?= htmlspecialchars($modelo->getNomeCompleto()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">
                    Ano
                </label>

                <input
                    type="number"
                    class="form-control"
                    name="ano"
                    value="<?= htmlspecialchars((string) ($veiculo->getAno() ?? '')) ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label">
                    KM
                </label>

                <input
                    type="number"
                    class="form-control"
                    name="km"
                    value="<?= htmlspecialchars((string) ($veiculo->getKm() ?? '')) ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label">
                    Câmbio
                </label>

                <select name="cambio" class="form-select">
                    <option value="">
                        Selecione o câmbio
                    </option>

                    <option value="manual" <?= $veiculo->getCambio() == 'manual' ? 'selected' : '' ?>>
                        manual
                    </option>

                    <option value="automático" <?= in_array($veiculo->getCambio(), ['automático', 'automatico'], true) ? 'selected' : '' ?>>
                        automático
                    </option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">
                    Combustível
                </label>

                <select name="combustivel" class="form-select">
                    <option value="">
                        Selecione o combustível
                    </option>

                    <option value="flex" <?= $veiculo->getCombustivel() == 'flex' ? 'selected' : '' ?>>
                        flex
                    </option>

                    <option value="gasolina" <?= $veiculo->getCombustivel() == 'gasolina' ? 'selected' : '' ?>>
                        gasolina
                    </option>

                    <option value="etanol" <?= $veiculo->getCombustivel() == 'etanol' ? 'selected' : '' ?>>
                        etanol
                    </option>

                    <option value="diesel" <?= $veiculo->getCombustivel() == 'diesel' ? 'selected' : '' ?>>
                        diesel
                    </option>

                    <option value="eletrico" <?= $veiculo->getCombustivel() == 'eletrico' ? 'selected' : '' ?>>
                        elétrico
                    </option>

                    <option value="hibrido" <?= $veiculo->getCombustivel() == 'hibrido' ? 'selected' : '' ?>>
                        híbrido
                    </option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">
                    Valor
                </label>

                <input
                    type="text"
                    class="form-control"
                    name="valor"
                    value="<?= htmlspecialchars($valor) ?>">
            </div>

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
                                <?= in_array($opcional->getId(), $opcionaisSelecionados, true) ? 'checked' : '' ?>>

                            <label
                                class="form-check-label text-gold"
                                for="opcional_<?= $opcional->getId() ?>">
                                <?= htmlspecialchars($opcional->getNome()) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-12">
                <div class="marcar-novo-container">
                    <input
                        type="checkbox"
                        class="marcar-novo-checkbox"
                        id="marcar_novo"
                        name="novo"
                        value="y"
                        <?= $veiculo->isNovo() ? 'checked' : '' ?>>

                    <label for="marcar_novo" class="marcar-novo-label">
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

            <div class="col-12 mt-3">
                <button class="btn btn-gold px-5">
                    <i class="bi bi-check-lg"></i>
                    Salvar
                </button>

                <a href="index.php" class="btn btn-voltar px-4">
                    Voltar
                </a>
            </div>
        </div>
    </form>
</div>
