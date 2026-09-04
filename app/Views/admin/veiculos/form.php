<div class="card-admin">
    <form method="POST" action="<?= url('admin/veiculos') ?>" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= e($veiculo->getId() ?? '') ?>">

        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label">
                    Modelo
                </label>

                <select name="id_modelo" class="form-select">
                    <option value="">
                        Selecione o modelo
                    </option>

                    <?php foreach ($modelos as $modelo): ?>
                        <option value="<?= $modelo->getId() ?>" <?= selected($veiculo->getIdModelo(), $modelo->getId()) ?>>
                            <?= e($modelo->getNomeCompleto()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">
                    Ano
                </label>

                <input
                    type="number"
                    class="form-control"
                    name="ano"
                    value="<?= e($veiculo->getAno() ?? '') ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label">
                    KM
                </label>

                <input
                    type="number"
                    class="form-control"
                    name="km"
                    value="<?= e($veiculo->getKm() ?? '') ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label">
                    Câmbio
                </label>

                <select name="cambio" class="form-select">
                    <option value="">
                        Selecione o câmbio
                    </option>
                    <option value="manual" <?= selected($veiculo->getCambio(), 'manual') ?>>
                        manual
                    </option>
                    <option value="automático" <?= in_array($veiculo->getCambio(), ['automático', 'automatico'], true) ? 'selected' : '' ?>>
                        automático
                    </option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">
                    Combustível
                </label>

                <select name="combustivel" class="form-select">
                    <option value="">
                        Selecione o combustível
                    </option>
                    <option value="flex" <?= selected($veiculo->getCombustivel(), 'flex') ?>>flex</option>
                    <option value="gasolina" <?= selected($veiculo->getCombustivel(), 'gasolina') ?>>gasolina</option>
                    <option value="etanol" <?= selected($veiculo->getCombustivel(), 'etanol') ?>>etanol</option>
                    <option value="diesel" <?= selected($veiculo->getCombustivel(), 'diesel') ?>>diesel</option>
                    <option value="eletrico" <?= selected($veiculo->getCombustivel(), 'eletrico') ?>>elétrico</option>
                    <option value="hibrido" <?= selected($veiculo->getCombustivel(), 'hibrido') ?>>híbrido</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">
                    Valor
                </label>

                <input
                    type="text"
                    class="form-control"
                    name="valor"
                    value="<?= e($valor) ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label">
                    Foto principal
                </label>

                <input
                    type="file"
                    class="form-control"
                    name="imagem_principal"
                    accept="image/*">
            </div>

            <div class="col-md-6">
                <?php if (!empty($veiculo->getImagemPrincipal())): ?>
                    <label class="form-label">
                        Imagem atual
                    </label>

                    <div class="preview-imagem">
                        <img src="<?= asset($veiculo->getImagemPrincipal()) ?>" class="img-fluid">
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-12">
                <label class="form-label">
                    Descrição
                </label>

                <textarea class="form-control" rows="5" name="descricao"><?= e($veiculo->getDescricao()) ?></textarea>
            </div>

            <div class="col-12">
                <label class="form-label">
                    Opcionais
                </label>

                <div class="opcionais-container">
                    <?php foreach ($opcionais as $opcional): ?>
                        <div class="form-check form-check-inline opcional-item">
                            <input
                                type="checkbox"
                                class="form-check-input"
                                name="opcionais[]"
                                value="<?= $opcional->getId() ?>"
                                id="opcional_<?= $opcional->getId() ?>"
                                <?= checked(in_array($opcional->getId(), $opcionaisSelecionados, true)) ?>>

                            <label class="form-check-label text-gold" for="opcional_<?= $opcional->getId() ?>">
                                <?= e($opcional->getNome()) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-12">
                <div class="marcar-novo-container">
                    <input
                        type="checkbox"
                        class="marcar-novo-checkbox"
                        id="marcar_novo"
                        name="novo"
                        value="y"
                        <?= checked($veiculo->isNovo()) ?>>

                    <label for="marcar_novo" class="marcar-novo-label">
                        <span class="marcar-novo-check">
                            <i class="bi bi-check-lg"></i>
                        </span>

                        <span class="marcar-novo-texto">
                            <strong>Marcar como novo</strong>
                            <small>Exibir este veículo com o selo "Novo"</small>
                        </span>
                    </label>
                </div>
            </div>

            <div class="col-12 mt-3">
                <button class="btn btn-gold px-5">
                    <i class="bi bi-check-lg"></i>
                    Salvar
                </button>

                <a href="<?= url('admin/veiculos') ?>" class="btn btn-voltar px-4">
                    Voltar
                </a>
            </div>
        </div>
    </form>
</div>
