<?php view('admin/partials/page-header', [
    'titulo' => 'Modelos',
    'acaoUrl' => url('admin/modelos/cadastro'),
    'acaoLabel' => 'Adicionar modelo',
]); ?>

<div class="card-admin">
    <div class="table-responsive">
        <table class="table table-admin align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Opções</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($modelos as $modelo): ?>
                    <tr>
                        <td><?= e($modelo->getId()) ?></td>
                        <td><?= e($modelo->getMarcaNome()) ?></td>
                        <td><?= e($modelo->getNome()) ?></td>
                        <td>
                            <a href="<?= url('admin/modelos/cadastro?id=' . $modelo->getId()) ?>" class="btn btn-sm btn-editar">
                                Editar
                            </a>

                            <a
                                href="<?= url('admin/modelos/excluir/' . $modelo->getId()) ?>"
                                class="btn btn-sm btn-excluir"
                                onclick="return confirm('Excluir modelo?')">
                                Excluir
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
