<?php view('admin/partials/page-header', [
    'titulo' => 'Veículos',
    'acaoUrl' => url('admin/veiculos/cadastro'),
    'acaoLabel' => 'Adicionar veículo',
]); ?>

<div class="card-admin">
    <div class="table-responsive">
        <table class="table table-admin align-middle">
            <thead>
                <tr>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Ano</th>
                    <th>KM</th>
                    <th>Valor</th>
                    <th>Opções</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($veiculos as $veiculo): ?>
                    <tr>
                        <td><?= e($veiculo->getMarcaNome()) ?></td>
                        <td><?= e($veiculo->getModeloNome()) ?></td>
                        <td><?= e($veiculo->getAno()) ?></td>
                        <td><?= numero($veiculo->getKm()) ?></td>
                        <td class="valor"><?= dinheiro($veiculo->getValor()) ?></td>
                        <td>
                            <a href="<?= url('admin/veiculos/cadastro?id=' . $veiculo->getId()) ?>" class="btn btn-sm btn-editar">
                                Editar
                            </a>

                            <a
                                href="<?= url('admin/veiculos/excluir/' . $veiculo->getId()) ?>"
                                class="btn btn-sm btn-excluir"
                                onclick="return confirm('Excluir veículo?')">
                                Excluir
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
