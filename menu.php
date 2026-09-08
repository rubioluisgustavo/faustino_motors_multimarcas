<nav class="navbar navbar-expand-lg menu-principal">
    <div class="container">

        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menuPrincipal">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuPrincipal">

            <ul class="navbar-nav mx-auto">

                <li class="nav-item">
                    <a class="nav-link" href="<?= site_path() ?>/">INÍCIO</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= site_path() ?>/?menu=empresa">A EMPRESA</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= site_path() ?>/?menu=vendidos">VENDIDOS</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= site_path() ?>/?menu=financiamento">FICHA DE FINANCIAMENTO</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">CONSIGNAÇÃO</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= site_path() ?>/?menu=contato">CONTATO</a>
                </li>

            </ul>

        </div>

    </div>
</nav>