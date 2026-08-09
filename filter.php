<?php

require_once "conexao.php";

$sqlMarcas = $pdo->query("
    SELECT id, nome 
    FROM marcas 
    ORDER BY nome ASC
");

$marcas = $sqlMarcas->fetchAll();

$sqlModelos = $pdo->query("
    SELECT id, id_marca, nome 
    FROM modelos 
    ORDER BY nome ASC
");

$modelos = $sqlModelos->fetchAll();

?>

<section class="filtro-veiculos py-4">
    <div class="container">

        <form method="GET" action="estoque.php">

            <div class="row g-3 align-items-end">

                <div class="col-lg-4 col-md-6">
                    <label class="form-label">Marca</label>

                    <select name="marca" class="form-select">

                        <option value="">Todas as marcas</option>

                        <?php foreach ($marcas as $marca): ?>

                            <option value="<?= $marca['id'] ?>">
                                <?= htmlspecialchars($marca['nome']) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="col-lg-4 col-md-6">
                    <label class="form-label">Modelo</label>

                    <select name="modelo" class="form-select">
                        <option value="">Todos os modelos</option>
                        <?php foreach ($modelos as $modelo): ?>

                            <option value="<?= $modelo['id'] ?>">
                                <?= htmlspecialchars($modelo['nome']) ?>
                            </option>

                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Ano</label>

                    <select name="ano" class="form-select">
                        <option value="">Todos</option>

                        <?php
                        for ($ano = date('Y'); $ano >= 1990; $ano--) {
                            echo "<option value='{$ano}'>{$ano}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6 d-grid">
                    <button class="btn btn-warning fw-bold">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>

            </div>

        </form>

    </div>
</section>