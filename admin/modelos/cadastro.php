<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";
require_once __DIR__ . '/ModeloRepository.php';
require_once __DIR__ . '/../marcas/MarcaRepository.php';
require_once __DIR__ . '/../includes/head.php';


$modeloRepository = new ModeloRepository($pdo);
$marcaRepository = new MarcaRepository($pdo);
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
$modelo = $id ? $modeloRepository->buscarPorId($id) : new Modelo();
$marcas = $marcaRepository->listar();



?>

<link href="../css/admin.css" rel="stylesheet">
<div class="card-admin">

    <form
        method="POST"
        action="<?= site_path() ?>/admin/modelos/salvar.php">



        <input
            type="hidden"
            name="id"
            value="<?= $modelo->getId() ?? '' ?>">





        <div class="row g-4">





            <!-- Marca -->
            <div class="col-md-6">


                <label class="form-label">
                    Marca
                </label>



                <select
                    name="id_marca"
                    class="form-select">



                    <option value="">
                        Selecione a marca
                    </option>




                    <?php foreach ($marcas as $m): ?>



                        <option

                            value="<?= $m->getId() ?>"
                            <?= $m->getId() == $modelo->getIdMarca() ? 'selected' : '' ?>>


                            <?= htmlspecialchars($m->getNome()) ?>


                        </option>



                    <?php endforeach; ?>



                </select>



            </div>







            <!-- Nome -->
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







            <!-- Botões -->
            <div class="col-12 mt-3">



                <button

                    class="btn btn-gold px-5">



                    <i class="bi bi-check-lg"></i>

                    Salvar



                </button>






                <a

                    href="<?= site_path() ?>/admin/modelos/"

                    class="btn btn-voltar px-4">



                    Voltar



                </a>



            </div>





        </div>



    </form>

</div>