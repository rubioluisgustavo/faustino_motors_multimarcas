<div class="card-admin">
    <form method="POST" action="<?= url('admin/marcas') ?>">
        <input type="hidden" name="id" value="<?= e($marca->getId() ?? '') ?>">

        <div class="row g-4">
            <div class="col-md-4">
                <label class="form-label">
                    Marca
                </label>

                <input
                    type="text"
                    class="form-control"
                    name="nome"
                    value="<?= e($marca->getNome()) ?>">
            </div>

            <div class="col-12 mt-3">
                <button class="btn btn-gold px-5">
                    <i class="bi bi-check-lg"></i>
                    Salvar
                </button>

                <a href="<?= url('admin/marcas') ?>" class="btn btn-voltar px-4">
                    Voltar
                </a>
            </div>
        </div>
    </form>
</div>
