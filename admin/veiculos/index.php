<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../../app/bootstrap.php';

$veiculoRepository = new App\Repositories\VeiculoRepository($pdo);

if (isset($_GET['excluir'])) {
    $veiculoRepository->excluir((int) $_GET['excluir']);

    header('Location:index.php');
    exit;
}

$veiculos = $veiculoRepository->listarAdmin();
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<link href="../css/admin.css" rel="stylesheet">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <h2 class="titulo-admin m-0">
        Veículos
    </h2>

    <a href="cadastro.php" class="btn btn-adicionar">
        <i class="bi bi-plus-circle"></i>
        Adicionar veículo
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
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Ano</th>
                    <th>KM</th>
                    <th>Valor</th>
                    <th>Opções</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($veiculos as $veiculo): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($veiculo->getMarcaNome()) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($veiculo->getModeloNome()) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars((string) $veiculo->getAno()) ?>
                        </td>

                        <td>
                            <?= number_format((int) $veiculo->getKm(), 0, ',', '.') ?>
                        </td>

                        <td class="valor">
                            R$ <?= number_format($veiculo->getValor(), 2, ',', '.') ?>
                        </td>

                        <td>
                            <a
                                href="cadastro.php?id=<?= $veiculo->getId() ?>"
                                class="btn btn-sm btn-editar">
                                Editar
                            </a>

                            <a
                                href="index.php?excluir=<?= $veiculo->getId() ?>"
                                class="btn btn-sm btn-excluir"
                                onclick="return confirm('Excluir veículo?')">
                                Excluir
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
