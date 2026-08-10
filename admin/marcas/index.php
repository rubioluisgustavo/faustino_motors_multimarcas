<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";


// excluir

if (isset($_GET['excluir'])) {

    $id = $_GET['excluir'];

    $sql = $pdo->prepare("
        DELETE FROM marcas 
        WHERE id = ?
    ");

    $sql->execute([$id]);


    header("Location:index.php");

    exit;
}



$sql = $pdo->query("

SELECT

id,
nome


FROM marcas

ORDER BY nome ASC


");


$marcas = $sql->fetchAll();


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
        href="/new/admin"
        class="btn btn-adicionar">

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
                    <th>Marca</th>
                    <th>Opções</th>
                </tr>

            </thead>


            <tbody>


                <?php foreach ($marcas as $m): ?>


                    <tr>


                        <td>
                            <?= htmlspecialchars($m['id']) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars($m['nome']) ?>
                        </td>



                        <td>


                            <a
                                href="cadastro.php?id=<?= $m['id'] ?>"
                                class="btn btn-sm btn-editar">
                                Editar
                            </a>



                            <a
                                href="index.php?excluir=<?= $m['id'] ?>"
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