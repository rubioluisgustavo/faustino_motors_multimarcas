<?php view('admin/partials/page-header', [
    'titulo' => 'Marcas',
    'acaoUrl' => url('admin/marcas/cadastro'),
    'acaoLabel' => 'Adicionar marca',
]); ?>

<div class="card-admin">
    <div class="table-responsive">
        <table class="table table-admin align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marca</th>
                    <th>Opções</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($marcas as $marca): ?>
                    <tr>
                        <td><?= e($marca->getId()) ?></td>
                        <td><?= e($marca->getNome()) ?></td>
                        <td>
                            <a href="<?= url('admin/marcas/cadastro?id=' . $marca->getId()) ?>" class="btn btn-sm btn-editar">
                                Editar
                            </a>

                            <a
                                href="<?= url('admin/marcas/excluir/' . $marca->getId()) ?>"
                                class="btn btn-sm btn-excluir"
                                onclick="return confirm('Excluir marca?')">
                                Excluir
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
