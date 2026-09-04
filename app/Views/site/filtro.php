<section class="filtro-veiculos py-4">
    <div class="container">
        <form method="GET" action="<?= url() ?>">
            <div class="row g-3 align-items-end">
                <div class="col-lg-4 col-md-6">
                    <label class="form-label">
                        Marca
                    </label>

                    <select name="marca" id="filtroMarca" class="form-select">
                        <option value="">
                            Todas as marcas
                        </option>

                        <?php foreach ($marcas as $marca): ?>
                            <option
                                value="<?= $marca->getId() ?>"
                                <?= selected($_GET['marca'] ?? '', $marca->getId()) ?>>
                                <?= e($marca->getNome()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-lg-4 col-md-6">
                    <label class="form-label">
                        Modelo
                    </label>

                    <select name="modelo" id="filtroModelo" class="form-select">
                        <option value="">
                            Todos os modelos
                        </option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">
                        Ano
                    </label>

                    <select name="ano" class="form-select">
                        <option value="">
                            Todos
                        </option>

                        <?php
                        $anoSelecionado = $_GET['ano'] ?? '';

                        for ($ano = date('Y'); $ano >= 1990; $ano--):
                        ?>
                            <option value="<?= $ano ?>" <?= selected($anoSelecionado, $ano) ?>>
                                <?= $ano ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6 d-grid">
                    <button type="submit" class="btn btn-warning fw-bold">
                        <i class="bi bi-search"></i>
                        Buscar
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    const modelos = <?= json_encode($modelosJson, JSON_UNESCAPED_UNICODE) ?>;
    const selectMarca = document.getElementById('filtroMarca');
    const selectModelo = document.getElementById('filtroModelo');
    const modeloSelecionado = '<?= e($_GET['modelo'] ?? '') ?>';

    function atualizarModelos() {
        const marcaSelecionada = selectMarca.value;
        selectModelo.innerHTML = '';

        const opcaoTodos = document.createElement('option');
        opcaoTodos.value = '';
        opcaoTodos.textContent = 'Todos os modelos';
        selectModelo.appendChild(opcaoTodos);

        if (!marcaSelecionada) {
            return;
        }

        modelos
            .filter(function(modelo) {
                return String(modelo.id_marca) === String(marcaSelecionada);
            })
            .forEach(function(modelo) {
                const option = document.createElement('option');
                option.value = modelo.id;
                option.textContent = modelo.nome;
                option.selected = String(modelo.id) === String(modeloSelecionado);

                selectModelo.appendChild(option);
            });
    }

    selectMarca.addEventListener('change', atualizarModelos);
    atualizarModelos();
</script>
