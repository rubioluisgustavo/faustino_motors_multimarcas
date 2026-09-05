<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";
require_once __DIR__ . '/MarcaRepository.php';
require_once __DIR__ . '/../includes/head.php';

$marcaRepository = new MarcaRepository($pdo);

if (isset($_GET['excluir'])) {
    $id = (int) $_GET['excluir'];
    if ($marcaRepository->contarRelacionamentos($id) > 0) {
        header('Location: index.php?erro=' . urlencode('Não é possível excluir a marca porque existem modelos vinculados a ela.'));
        exit;
    }

    $marcaRepository->excluir($id);

    header("Location:index.php");
    exit;
}

$marcas = $marcaRepository->listar();
$erro = $_GET['erro'] ?? null;
?>

<link href="../marcas/marcas.css" rel="stylesheet">


<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">


    <h2 class="titulo-admin m-0">
        Marcas
    </h2>


    <a
        href="cadastro.php"
        class="btn btn-adicionar">

        <i class="bi bi-plus-circle"></i>

        Adicionar marca

    </a>

    <a
        href="../index.php"
        class="btn btn-adicionar">

        <i class="bi bi-arrow-left-circle"></i>

        voltar

    </a>


</div>

<?php if ($erro): ?>
    <div class="alert alert-warning"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

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