<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";
require_once __DIR__ . '/MarcaRepository.php';
require_once __DIR__ . '/../includes/head.php';

$marcaRepository = new MarcaRepository($pdo);
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

$marca = new Marca();

if ($id) {
    $marcaExistente = $marcaRepository->buscarPorId($id);

    if ($marcaExistente) {
        $marca = $marcaExistente;
    }
}
?>

<link href="../css/admin.css" rel="stylesheet">
<div class="card-admin">

    <form class="admin-form"
        method="POST"
        action="<?= site_path() ?>/admin/marcas/salvar.php"
        enctype="multipart/form-data">


        <input
            type="hidden"
            name="id"
            value="<?= $marca->getId() ?? '' ?>">



        <div class="row g-4">


            <div class="col-md-4 form-group">


                <label class="form-label">
                    Marca
                </label>


                <input
                    type="text"
                    class="form-control"
                    name="nome"
                    value="<?= htmlspecialchars($marca->getNome()) ?>">


            </div>




            <!-- BotÃµes -->
            <div class="col-12 mt-3 form-actions">


                <button
                    class="btn btn-gold px-5">

                    <i class="bi bi-check-lg"></i>
                    Salvar


                </button>



                <a
                    href="<?= site_path() ?>/admin/marcas/"
                    class="btn btn-voltar px-4">

                    Voltar

                </a>


            </div>



        </div>


    </form>

</div>