<?php view('admin/partials/page-header', [
    'titulo' => 'Opcionais',
    'acaoUrl' => url('admin/opcionais/cadastro'),
    'acaoLabel' => 'Adicionar opcional',
]); ?>

<div class="card-admin">
    <div class="table-responsive">
        <table class="table table-admin align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Opções</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($opcionais as $opcional): ?>
                    <tr>
                        <td><?= e($opcional->getId()) ?></td>
                        <td><?= e($opcional->getNome()) ?></td>
                        <td>
                            <a href="<?= url('admin/opcionais/cadastro?id=' . $opcional->getId()) ?>" class="btn btn-sm btn-editar">
                                Editar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
