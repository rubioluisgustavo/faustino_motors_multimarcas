<?php

    require_once "includes/auth.php";

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <title>Faustino Motors Multimarcas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="css/admin.css" rel="stylesheet">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

    <div class="container admin-container">

        <div class="mb-5">

            <h1 class="titulo-admin">

                Painel Administrativo

            </h1>

            <p class="text-light">

                Bem-vindo ao sistema da <strong class="text-gold">Faustino Motors Multimarcas</strong>.

            </p>

        </div>


        <div class="row g-4">

            <!-- MARCAS -->

            <div class="col-lg-4 col-md-6">

                <div class="card-dashboard">

                    <div class="icone-dashboard">

                        <i class="bi bi-award-fill"></i>

                    </div>

                    <h4>

                        Marcas

                    </h4>

                    <p>

                        Gerencie todas as marcas cadastradas.

                    </p>

                    <a
                        href="marcas/index.php"
                        class="btn btn-adicionar w-100">

                        Acessar

                    </a>

                </div>

            </div>

            <!-- MODELOS -->

            <div class="col-lg-4 col-md-6">

                <div class="card-dashboard">

                    <div class="icone-dashboard">

                        <i class="bi bi-list-ul"></i>

                    </div>

                    <h4>

                        Modelos

                    </h4>

                    <p>

                        Cadastre e organize os modelos dos veículos.

                    </p>

                    <a
                        href="modelos/index.php"
                        class="btn btn-adicionar w-100">

                        Acessar

                    </a>

                </div>

            </div>



            <!-- VEÍCULOS -->

            <div class="col-lg-4 col-md-6">

                <div class="card-dashboard">

                    <div class="icone-dashboard">

                        <i class="bi bi-car-front-fill"></i>

                    </div>

                    <h4>

                        Veículos

                    </h4>

                    <p>

                        Cadastre, edite e exclua veículos do estoque.

                    </p>

                    <a
                        href="veiculos/index.php"
                        class="btn btn-adicionar w-100">

                        Acessar

                    </a>

                </div>

            </div>





            <div class="col-lg-4 col-md-6">

                <div class="card-dashboard">

                    <div class="icone-dashboard">

                        <i class="bi bi-tools"></i>

                    </div>

                    <h4>

                        Opcionais

                    </h4>

                    <p>

                        Cadastre e gerencie itens opcionais dos veículos.

                    </p>

                    <a
                        href="opcionais/index.php"
                        class="btn btn-adicionar w-100">

                        Acessar

                    </a>

                </div>

            </div>


        </div>

    </div>

</body>

</html>