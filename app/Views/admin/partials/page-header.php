<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <h2 class="titulo-admin m-0">
        <?= e($titulo) ?>
    </h2>

    <div class="d-flex gap-2 flex-wrap">
        <?php if (!empty($acaoUrl) && !empty($acaoLabel)): ?>
            <a href="<?= e($acaoUrl) ?>" class="btn btn-adicionar">
                <i class="bi bi-plus-circle"></i>
                <?= e($acaoLabel) ?>
            </a>
        <?php endif; ?>

        <a href="<?= url('admin') ?>" class="btn btn-adicionar">
            <i class="bi bi-arrow-left-circle"></i>
            Voltar
        </a>
    </div>
</div>
