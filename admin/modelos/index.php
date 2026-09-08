<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";
require_once __DIR__ . '/ModeloRepository.php';
require_once __DIR__ . '/../includes/head.php';

$modeloRepository = new ModeloRepository($pdo);

// excluir modelo

if (isset($_GET['excluir'])) {
    $id = (int) $_GET['excluir'];
    if ($modeloRepository->contarRelacionamentos($id) > 0) {
        header('Location: ' . site_path() . '/admin/modelos/?erro=' . urlencode('Não é possível excluir o modelo porque existem veículos vinculados a ele.'));
        exit;
    }

    $modeloRepository->excluir($id);
    header("Location: " . site_path() . "/admin/modelos/");
    exit;
}





// listar modelos

$modelos = $modeloRepository->listar();
$erro = $_GET['erro'] ?? null;

?>
<link href="../modelos/modelos.css" rel="stylesheet">


<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">


    <h2 class="titulo-admin m-0">
        Modelos
    </h2>


    <a
        href="<?= site_path() ?>/admin/modelos/cadastro.php"
        class="btn btn-adicionar">

        <i class="bi bi-plus-circle"></i>

        Adicionar modelo

    </a>


    <a
        href="<?= site_path() ?>/admin/"
        class="btn btn-adicionar">

        <i class="bi bi-arrow-left-circle"></i>

        Voltar

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

                    <th>Modelo</th>

                    <th>Opções</th>

                </tr>

            </thead>



            <tbody>


                <?php foreach ($modelos as $m): ?>


                    <tr>


                        <td>
                            <?= htmlspecialchars((string) $m->getId()) ?>
                        </td>



                        <td>
                            <?= htmlspecialchars($m->getMarca()) ?>
                        </td>



                        <td>
                            <?= htmlspecialchars($m->getNome()) ?>
                        </td>



                        <td>


                            <a
                                href="<?= site_path() ?>/admin/modelos/cadastro.php?id=<?= $m->getId() ?>"
                                class="btn btn-sm btn-editar">

                                Editar

                            </a>




                            <a
                                href="<?= site_path() ?>/admin/modelos/?excluir=<?= $m->getId() ?>"
                                class="btn btn-sm btn-excluir"
                                onclick="return confirm('Excluir modelo?')">

                                Excluir

                            </a>



                        </td>


                    </tr>



                <?php endforeach; ?>



            </tbody>


        </table>


    </div>

</div>