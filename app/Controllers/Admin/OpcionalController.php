<?php

namespace App\Controllers\Admin;

use App\Models\Opcional;
use App\Repositories\OpcionalRepository;
use PDO;

class OpcionalController
{
    private OpcionalRepository $opcionais;

    public function __construct(PDO $pdo)
    {
        $this->opcionais = new OpcionalRepository($pdo);
    }

    public function index(): array
    {
        return ['opcionais' => $this->opcionais->listar()];
    }

    public function form(?int $id): array
    {
        $opcional = new Opcional();

        if ($id !== null) {
            $opcional = $this->opcionais->buscarPorId($id) ?? $opcional;
        }

        return ['opcional' => $opcional];
    }

    public function salvar(array $dados): void
    {
        $id = isset($dados['id']) && $dados['id'] !== '' ? (int) $dados['id'] : null;
        $nome = trim($dados['nome'] ?? '');

        if ($nome === '') {
            redirect('admin/opcionais/cadastro' . ($id ? '?id=' . $id : ''));
        }

        $this->opcionais->salvar(new Opcional($id, $nome));
    }

    public function excluir(int $id): void
    {
        $this->opcionais->excluir($id);
    }
}
