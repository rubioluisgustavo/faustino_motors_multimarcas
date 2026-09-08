<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";
require_once __DIR__ . '/OpcionalRepository.php';
require_once __DIR__ . '/../includes/head.php';

$opcionalRepository = new OpcionalRepository($pdo);

// excluir

if (isset($_GET['excluir'])) {
    $id = (int) $_GET['excluir'];
    if ($opcionalRepository->contarRelacionamentos($id) > 0) {
        header('Location: ' . site_path() . '/admin/opcionais/?erro=' . urlencode('Não é possível excluir o opcional porque ele está vinculado a veículos.'));
        exit;
    }

    $opcionalRepository->excluir($id);
    header("Location:" . site_path() . "/admin/opcionais/");
    exit;
}



$opcionais = $opcionalRepository->listar();
$erro = $_GET['erro'] ?? null;


?>

<link href="../opcionais/opcionais.css" rel="stylesheet">


<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">


    <h2 class="titulo-admin m-0">
        Opcionais
    </h2>


    <a
        href="<?= site_path() ?>/admin/opcionais/cadastro.php"
        class="btn btn-adicionar">

        <i class="bi bi-plus-circle"></i>

        Adicionar opcional

    </a>

    <a
        href="<?= site_path() ?>/admin/"
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
                    <th>Nome</th>
                    <th>Opções</th>
                </tr>

            </thead>


            <tbody>


                <?php foreach ($opcionais as $o): ?>


                    <tr>


                        <td>
                            <?= htmlspecialchars((string) $o->getId()) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars($o->getNome()) ?>
                        </td>



                        <td>

                            <a
                                href="<?= site_path() ?>/admin/opcionais/cadastro.php?id=<?= $o->getId() ?>"
                                class="btn btn-sm btn-editar">
                                Editar
                            </a>

                            <a
                                href="<?= site_path() ?>/admin/opcionais/?excluir=<?= $o->getId() ?>"
                                class="btn btn-sm btn-excluir"
                                onclick="return confirm('Excluir opcional?')">
                                Excluir
                            </a>

                        </td>


                    </tr>


                <?php endforeach; ?>


            </tbody>


        </table>


    </div>

</div>