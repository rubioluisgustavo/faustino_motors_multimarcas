<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../../app/bootstrap.php';

$opcionalRepository = new App\Repositories\OpcionalRepository($pdo);

if (isset($_GET['excluir'])) {
    $opcionalRepository->excluir((int) $_GET['excluir']);

    header('Location:index.php');
    exit;
}

$opcionais = $opcionalRepository->listar();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<link href="../css/admin.css" rel="stylesheet">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <h2 class="titulo-admin m-0">
        Opcionais
    </h2>

    <a href="cadastro.php" class="btn btn-adicionar">
        <i class="bi bi-plus-circle"></i>
        Adicionar opcional
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
                    <th>Nome</th>
                    <th>Opções</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($opcionais as $opcional): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars((string) $opcional->getId()) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($opcional->getNome()) ?>
                        </td>

                        <td>
                            <a
                                href="cadastro.php?id=<?= $opcional->getId() ?>"
                                class="btn btn-sm btn-editar">
                                Editar
                            </a>

                            <!-- <a
                                href="index.php?excluir=<?= $opcional->getId() ?>"
                                class="btn btn-sm btn-excluir"
                                onclick="return confirm('Excluir opcional?')">
                                Excluir
                            </a> -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
