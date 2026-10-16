<?php

require_once "conexao.php";
require_once __DIR__ . '/admin/marcas/MarcaRepository.php';
require_once __DIR__ . '/admin/modelos/ModeloRepository.php';

$marcas = (new MarcaRepository($pdo))->listarDisponiveis();
$modelos = (new ModeloRepository($pdo))->listarDisponiveis();

?>

<section class="filtro-veiculos py-4">

    <div class="container">

        <form method="GET" action="<?= site_path() ?>/">

            <div class="row g-3 align-items-end">


                <!-- MARCA -->

                <div class="col-lg-4 col-md-6">

                    <label class="form-label">
                        Marca
                    </label>

                    <select
                        name="marca"
                        id="filtroMarca"
                        class="form-select">

                        <option value="">
                            Todas as marcas
                        </option>

                        <?php foreach ($marcas as $marca): ?>

                            <option
                                value="<?= $marca->getId() ?>"
                                <?= (
                                    isset($_GET['marca']) &&
                                    $_GET['marca'] == $marca->getId()
                                ) ? 'selected' : '' ?>>

                                <?= htmlspecialchars($marca->getNome()) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <!-- MODELO -->

                <div class="col-lg-4 col-md-6">

                    <label class="form-label">
                        Modelo
                    </label>

                    <select
                        name="modelo"
                        id="filtroModelo"
                        class="form-select">

                        <option value="">
                            Todos os modelos
                        </option>

                    </select>

                </div>


                <!-- ANO -->

                <div class="col-lg-2 col-md-6">

                    <label class="form-label">
                        Ano
                    </label>

                    <select
                        name="ano"
                        class="form-select">

                        <option value="">
                            Todos
                        </option>

                        <?php
                        $anoSelecionado = $_GET['ano'] ?? '';
                        $anosDisponiveis = $pdo->query(
                            "SELECT DISTINCT ano FROM veiculos WHERE ano IS NOT NULL AND ano <> '' ORDER BY ano DESC"
                        )->fetchAll(PDO::FETCH_COLUMN);
                        ?>
                        <?php foreach ($anosDisponiveis as $anoDisponivel): ?>
                            <option
                                value="<?= htmlspecialchars($anoDisponivel, ENT_QUOTES, 'UTF-8') ?>"
                                <?= $anoSelecionado === $anoDisponivel ? 'selected' : '' ?>>
                                <?= htmlspecialchars($anoDisponivel, ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>

                    </select>

                </div>


                <!-- BUSCAR -->

                <div class="col-lg-2 col-md-6 d-grid">

                    <button
                        type="submit"
                        class="btn btn-warning fw-bold">

                        <i class="bi bi-search"></i>

                        Buscar

                    </button>

                </div>

            </div>

        </form>

    </div>

</section>


<script>
    const modelos = <?= json_encode(array_map(
        static fn (Modelo $modelo): array => [
            'id' => $modelo->getId(),
            'id_marca' => $modelo->getIdMarca(),
            'nome' => $modelo->getNome(),
        ],
        $modelos
    ), JSON_UNESCAPED_UNICODE) ?>;

    const selectMarca = document.getElementById('filtroMarca');
    const selectModelo = document.getElementById('filtroModelo');


    function atualizarModelos() {

        const marcaSelecionada = selectMarca.value;

        const modeloSelecionado =
            '<?= htmlspecialchars($_GET['modelo'] ?? '', ENT_QUOTES) ?>';


        // Limpa os modelos

        selectModelo.innerHTML = '';


        // Opção padrão

        const opcaoTodos = document.createElement('option');

        opcaoTodos.value = '';

        opcaoTodos.textContent =
            marcaSelecionada ?
            'Todos os modelos' :
            'Todos os modelos';

        selectModelo.appendChild(opcaoTodos);


        // Se nenhuma marca estiver selecionada,
        // não mostra os modelos

        if (!marcaSelecionada) {

            return;

        }


        // Filtra somente os modelos da marca

        modelos
            .filter(function(modelo) {

                return String(modelo.id_marca) === String(marcaSelecionada);

            })
            .forEach(function(modelo) {

                const option = document.createElement('option');

                option.value = modelo.id;

                option.textContent = modelo.nome;


                // Mantém o modelo selecionado
                // depois de uma busca

                if (String(modelo.id) === String(modeloSelecionado)) {

                    option.selected = true;

                }


                selectModelo.appendChild(option);

            });

    }


    // Quando mudar a marca

    selectMarca.addEventListener('change', function() {

        atualizarModelos();

    });


    // Inicializa ao carregar a página

    atualizarModelos();
</script>