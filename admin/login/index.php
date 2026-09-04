<?php

session_start();

if (isset($_SESSION['usuario'])) {

    header("Location: ../index.php");

    exit;
}

?>

<?php require_once __DIR__ . '/../includes/head.php'; ?>

<link href="login.css" rel="stylesheet">
<div class="login-container">


    <div class="login-card">


        <div class="login-logo">

            <h2>
                FAUSTINO MOTORS MULTIMARCAS
            </h2>

            <span>
                Painel Administrativo
            </span>

        </div>




        <form method="POST" action="autenticar.php">



            <div class="mb-3">


                <label class="form-label">
                    Email
                </label>


                <input

                    type="email"

                    name="email"

                    class="form-control"

                    placeholder="Digite seu email"

                    required>


            </div>






            <div class="mb-3">


                <label class="form-label">
                    Senha
                </label>


                <input

                    type="password"

                    name="senha"

                    class="form-control"

                    placeholder="Digite sua senha"

                    required>


            </div>






            <button

                class="btn btn-gold w-100 mt-3">


                <i class="bi bi-box-arrow-in-right"></i>

                Entrar


            </button>




        </form>

        <?php if (isset($_GET['erro'])): ?>

            <div class="alert alert-danger">
                E-mail ou senha inválidos.
            </div>

        <?php endif; ?>


    </div>


</div>