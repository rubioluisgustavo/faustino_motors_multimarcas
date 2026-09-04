<div class="card-admin">
    <form method="POST" action="<?= url('admin/modelos') ?>">
        <input type="hidden" name="id" value="<?= e($modelo->getId() ?? '') ?>">

        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label">
                    Marca
                </label>

                <select name="id_marca" class="form-select">
                    <option value="">
                        Selecione a marca
                    </option>

                    <?php foreach ($marcas as $marca): ?>
                        <option value="<?= $marca->getId() ?>" <?= selected($modelo->getIdMarca() ?? '', $marca->getId()) ?>>
                            <?= e($marca->getNome()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">
                    Nome do Modelo
                </label>

                <input
                    type="text"
                    class="form-control"
                    name="nome"
                    value="<?= e($modelo->getNome()) ?>">
            </div>

            <div class="col-12 mt-3">
                <button class="btn btn-gold px-5">
                    <i class="bi bi-check-lg"></i>
                    Salvar
                </button>

                <a href="<?= url('admin/modelos') ?>" class="btn btn-voltar px-4">
                    Voltar
                </a>
            </div>
        </div>
    </form>
</div>
