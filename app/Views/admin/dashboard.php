<div class="mb-5">
    <h1 class="titulo-admin">
        Painel Administrativo
    </h1>

    <p class="text-light">
        Bem-vindo ao sistema da <strong class="text-gold">Faustino Motors Multimarcas</strong>.
    </p>
</div>

<div class="row g-4">
    <div class="col-lg-4 col-md-6">
        <div class="card-dashboard">
            <div class="icone-dashboard">
                <i class="bi bi-award-fill"></i>
            </div>

            <h4>Marcas</h4>
            <p>Gerencie todas as marcas cadastradas.</p>

            <a href="<?= url('admin/marcas') ?>" class="btn btn-adicionar w-100">
                Acessar
            </a>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="card-dashboard">
            <div class="icone-dashboard">
                <i class="bi bi-list-ul"></i>
            </div>

            <h4>Modelos</h4>
            <p>Cadastre e organize os modelos dos veículos.</p>

            <a href="<?= url('admin/modelos') ?>" class="btn btn-adicionar w-100">
                Acessar
            </a>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="card-dashboard">
            <div class="icone-dashboard">
                <i class="bi bi-car-front-fill"></i>
            </div>

            <h4>Veículos</h4>
            <p>Cadastre, edite e exclua veículos do estoque.</p>

            <a href="<?= url('admin/veiculos') ?>" class="btn btn-adicionar w-100">
                Acessar
            </a>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="card-dashboard">
            <div class="icone-dashboard">
                <i class="bi bi-tools"></i>
            </div>

            <h4>Opcionais</h4>
            <p>Cadastre e gerencie itens opcionais dos veículos.</p>

            <a href="<?= url('admin/opcionais') ?>" class="btn btn-adicionar w-100">
                Acessar
            </a>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="card-dashboard">
            <div class="icone-dashboard">
                <i class="bi bi-box-arrow-right"></i>
            </div>

            <h4>Sair</h4>
            <p>Encerrar sessão do painel administrativo.</p>

            <a href="<?= url('admin/logout') ?>" class="btn btn-voltar w-100">
                Sair
            </a>
        </div>
    </div>
</div>
