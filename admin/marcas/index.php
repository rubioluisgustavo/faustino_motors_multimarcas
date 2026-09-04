<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../../app/bootstrap.php';

$marcaRepository = new App\Repositories\MarcaRepository($pdo);

if (isset($_GET['excluir'])) {
    $marcaRepository->excluir((int) $_GET['excluir']);

    header('Location:index.php');
    exit;
}

$marcas = $marcaRepository->listar();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<link href="../css/admin.css" rel="stylesheet">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <h2 class="titulo-admin m-0">
        Marcas
    </h2>

    <a href="cadastro.php" class="btn btn-adicionar">
        <i class="bi bi-plus-circle"></i>
        Adicionar marca
    </a>

    <a href="../index.php" class="btn btn-adicionar">
        <i class="bi bi-plus-circle"></i>
        voltar
    </a>
</div>

<div class="card-admin">
    <div class="table-responsive">
        <table class="table table-admin align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marca</th>
                    <th>Opções</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($marcas as $marca): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars((string) $marca->getId()) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($marca->getNome()) ?>
                        </td>

                        <td>
                            <a
                                href="cadastro.php?id=<?= $marca->getId() ?>"
                                class="btn btn-sm btn-editar">
                                Editar
                            </a>

                            <a
                                href="index.php?excluir=<?= $marca->getId() ?>"
                                class="btn btn-sm btn-excluir"
                                onclick="return confirm('Excluir marca?')">
                                Excluir
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
