<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";
require_once __DIR__ . '/ModeloRepository.php';
require_once __DIR__ . '/../includes/head.php';

$modeloRepository = new ModeloRepository($pdo);

// excluir modelo

if (isset($_GET['excluir'])) {


    $modeloRepository->excluir((int) $_GET['excluir']);



    header("Location: index.php");

    exit;
}





// listar modelos

$modelos = $modeloRepository->listar();

?>
<link href="../modelos/modelos.css" rel="stylesheet">


<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">


    <h2 class="titulo-admin m-0">
        Modelos
    </h2>


    <a
        href="cadastro.php"
        class="btn btn-adicionar">

        <i class="bi bi-plus-circle"></i>

        Adicionar modelo

    </a>


    <a
        href="/new/admin"
        class="btn btn-adicionar">

        <i class="bi bi-arrow-left-circle"></i>

        Voltar

    </a>


</div>

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
                                href="cadastro.php?id=<?= $m->getId() ?>"
                                class="btn btn-sm btn-editar">

                                Editar

                            </a>




                            <a
                                href="index.php?excluir=<?= $m->getId() ?>"
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