<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";

// excluir

if (isset($_GET['excluir'])) {

    $id = $_GET['excluir'];

    $sql = $pdo->prepare("
        DELETE FROM veiculos 
        WHERE id = ?
    ");

    $sql->execute([$id]);


    header("Location:index.php");

    exit;
}



$sql = $pdo->query("

SELECT

v.id,
ma.nome AS marca,
mo.nome AS modelo,
v.novo,
v.ano,
v.km,
v.valor


FROM veiculos v


INNER JOIN modelos mo
ON mo.id = v.id_modelo


INNER JOIN marcas ma
ON ma.id = mo.id_marca


ORDER BY v.id DESC


");


$veiculos = $sql->fetchAll();


?>

<link href="../veiculos/veiculos.css" rel="stylesheet">


<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">


    <h2 class="titulo-admin m-0">
        Veículos
    </h2>


    <a
        href="cadastro.php"
        class="btn btn-adicionar">

        <i class="bi bi-plus-circle"></i>

        Adicionar veículo

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

                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Ano</th>
                    <th>KM</th>
                    <th>Valor</th>
                    <th>Opções</th>

                </tr>

            </thead>


            <tbody>


                <?php foreach ($veiculos as $v): ?>


                    <tr>


                        <td>
                            <?= htmlspecialchars($v['marca']) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars($v['modelo']) ?>
                        </td>


                        <td>
                            <?= $v['ano'] ?>
                        </td>


                        <td>
                            <?= number_format($v['km'], 0, ",", ".") ?>
                        </td>


                        <td class="valor">

                            R$ <?= number_format((float)$v['valor'], 2, ",", ".") ?>

                        </td>



                        <td>


                            <a
                                href="cadastro.php?id=<?= $v['id'] ?>"
                                class="btn btn-sm btn-editar">
                                Editar
                            </a>



                            <a
                                href="index.php?excluir=<?= $v['id'] ?>"
                                class="btn btn-sm btn-excluir"
                                onclick="return confirm('Excluir veÃ­culo?')">
                                Excluir
                            </a>


                        </td>


                    </tr>


                <?php endforeach; ?>


            </tbody>


        </table>


    </div>

</div>