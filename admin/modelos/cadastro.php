<?php

require_once "../../conexao.php";


$id = $_GET['id'] ?? null;



$modelo = [

    'id_marca' => '',
    'nome' => ''

];





if ($id) {


    $sql = $pdo->prepare("

        SELECT *

        FROM modelos

        WHERE id=?

    ");



    $sql->execute([$id]);



    $modelo = $sql->fetch();
}





$marcas = $pdo->query("

    SELECT

        id,

        nome


    FROM marcas


    ORDER BY nome


")->fetchAll();



?>

<link href="../css/admin.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

<div class="card-admin">

    <form
        method="POST"
        action="salvar.php">



        <input
            type="hidden"
            name="id"
            value="<?= $id ?>">





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

                            value="<?= $m['id'] ?>"

                            <?= $m['id'] == ($modelo['id_marca'] ?? '') ? 'selected' : '' ?>>


                            <?= htmlspecialchars($m['nome']) ?>


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

                    value="<?= $modelo['nome'] ?? '' ?>">



            </div>







            <!-- Botões -->
            <div class="col-12 mt-3">



                <button

                    class="btn btn-gold px-5">



                    <i class="bi bi-check-lg"></i>

                    Salvar



                </button>






                <a

                    href="index.php"

                    class="btn btn-voltar px-4">



                    Voltar



                </a>



            </div>





        </div>



    </form>

</div>