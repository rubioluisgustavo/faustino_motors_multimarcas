<?php

require_once "includes/auth.php";

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Painel Administrativo</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <link href="css/admin.css" rel="stylesheet">

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