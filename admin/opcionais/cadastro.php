<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";
require_once __DIR__ . '/OpcionalRepository.php';
require_once __DIR__ . '/../includes/head.php';

$opcionalRepository = new OpcionalRepository($pdo);
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
$opcional = $id ? $opcionalRepository->buscarPorId($id) : new Opcional();

?>

<link href="../css/admin.css" rel="stylesheet">
<div class="card-admin">

    <form class="admin-form"
        method="POST"
        action="<?= site_path() ?>/admin/opcionais/salvar.php"
        enctype="multipart/form-data">


        <input
            type="hidden"
            name="id"
            value="<?= $opcional->getId() ?? '' ?>">



        <div class="row g-4">


            <div class="col-md-4 form-group">


                <label class="form-label">
                    Nome
                </label>


                <input
                    type="text"
                    class="form-control"
                    name="nome"
                    value="<?= htmlspecialchars($opcional->getNome()) ?>">


            </div>




            <!-- BotÃµes -->
            <div class="col-12 mt-3 form-actions">


                <button
                    class="btn btn-gold px-5">

                    <i class="bi bi-check-lg"></i>
                    Salvar


                </button>



                <a
                    href="<?= site_path() ?>/admin/opcionais/"
                    class="btn btn-voltar px-4">

                    Voltar

                </a>


            </div>



        </div>


    </form>

</div>