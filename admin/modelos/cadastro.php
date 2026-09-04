<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../../app/bootstrap.php';

$modeloRepository = new App\Repositories\ModeloRepository($pdo);
$marcaRepository = new App\Repositories\MarcaRepository($pdo);
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

$modelo = new App\Models\Modelo();

if ($id) {
    $modeloExistente = $modeloRepository->buscarPorId($id);

    if ($modeloExistente) {
        $modelo = $modeloExistente;
    }
}

$marcas = $marcaRepository->listar();
?>

<link href="../css/admin.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

<div class="card-admin">
    <form method="POST" action="salvar.php">
        <input
            type="hidden"
            name="id"
            value="<?= $modelo->getId() ?? '' ?>">

        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label">
                    Marca
                </label>

                <select name="id_marca" class="form-select">
                    <option value="">
                        Selecione a marca
                    </option>

                    <?php foreach ($marcas as $marca): ?>
                        <option
                            value="<?= $marca->getId() ?>"
                            <?= $marca->getId() == ($modelo->getIdMarca() ?? '') ? 'selected' : '' ?>>
                            <?= htmlspecialchars($marca->getNome()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">
                    Nome do Modelo
                </label>

                <input
                    type="text"
                    class="form-control"
                    name="nome"
                    value="<?= htmlspecialchars($modelo->getNome()) ?>">
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
