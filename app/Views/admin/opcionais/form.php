<div class="card-admin">
    <form method="POST" action="<?= url('admin/opcionais') ?>">
        <input type="hidden" name="id" value="<?= e($opcional->getId() ?? '') ?>">

        <div class="row g-4">
            <div class="col-md-4">
                <label class="form-label">
                    Nome
                </label>

                <input
                    type="text"
                    class="form-control"
                    name="nome"
                    value="<?= e($opcional->getNome()) ?>">
            </div>

            <div class="col-12 mt-3">
                <button class="btn btn-gold px-5">
                    <i class="bi bi-check-lg"></i>
                    Salvar
                </button>

                <a href="<?= url('admin/opcionais') ?>" class="btn btn-voltar px-4">
                    Voltar
                </a>
            </div>
        </div>
    </form>
</div>
