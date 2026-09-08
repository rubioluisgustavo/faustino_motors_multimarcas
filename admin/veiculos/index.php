<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";
require_once __DIR__ . '/VeiculoRepository.php';
require_once __DIR__ . '/../includes/head.php';

$veiculoRepository = new VeiculoRepository($pdo);

// excluir

if (isset($_GET['excluir'])) {

    $id = filter_input(INPUT_GET, 'excluir', FILTER_VALIDATE_INT);
    if ($id && $veiculoRepository->contarRelacionamentos($id) > 0) {
        header('Location: ' . site_path() . '/admin/veiculos/?erro=' . urlencode('Não é possível excluir o veículo porque existem opcionais vinculados a ele.'));
        exit;
    }

    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM veiculos WHERE id = ?");
        $stmt->execute([$id]);
    }


    header("Location:" . site_path() . "/admin/veiculos/");

    exit;
}



$veiculos = $veiculoRepository->listar();
$erro = $_GET['erro'] ?? null;


?>

<link href="../veiculos/veiculos.css" rel="stylesheet">


<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">


    <h2 class="titulo-admin m-0">
        Veículos
    </h2>


    <a
        href="<?= site_path() ?>/admin/veiculos/cadastro.php"
        class="btn btn-adicionar">

        <i class="bi bi-plus-circle"></i>

        Adicionar veículo

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
                    <th>Imagem</th>
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
                            <?php if ($v->getImagemPrincipal()): ?>
                                <img
                                    src="../../<?= htmlspecialchars($v->getImagemPrincipal()) ?>"
                                    alt="<?= htmlspecialchars($v->getMarca() . ' ' . $v->getModelo()) ?>"
                                    class="veiculo-imagem-admin">
                            <?php else: ?>
                                Sem imagem
                            <?php endif; ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($v->getMarca()) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars($v->getModelo()) ?>
                        </td>


                        <td>
                            <?= $v->getAno() ?>
                        </td>


                        <td>
                            <?= number_format($v->getKm(), 0, ",", ".") ?>
                        </td>


                        <td class="valor">

                            R$ <?= number_format($v->getValor(), 2, ",", ".") ?>

                        </td>



                        <td>


                            <a
                                href="<?= site_path() ?>/admin/veiculos/cadastro.php?id=<?= $v->getId() ?>"
                                class="btn btn-sm btn-editar">
                                Editar
                            </a>



                            <a
                                href="<?= site_path() ?>/admin/veiculos/?excluir=<?= $v->getId() ?>"
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