<?php

namespace App\Controllers\Admin;

use App\Models\Marca;
use App\Repositories\MarcaRepository;
use PDO;

class MarcaController
{
    private MarcaRepository $marcas;

    public function __construct(PDO $pdo)
    {
        $this->marcas = new MarcaRepository($pdo);
    }

    public function index(): array
    {
        return ['marcas' => $this->marcas->listar()];
    }

    public function form(?int $id): array
    {
        $marca = new Marca();

        if ($id !== null) {
            $marca = $this->marcas->buscarPorId($id) ?? $marca;
        }

        return ['marca' => $marca];
    }

    public function salvar(array $dados): void
    {
        $id = isset($dados['id']) && $dados['id'] !== '' ? (int) $dados['id'] : null;
        $nome = trim($dados['nome'] ?? '');

        if ($nome === '') {
            redirect('admin/marcas/cadastro' . ($id ? '?id=' . $id : ''));
        }

        $this->marcas->salvar(new Marca($id, $nome));
    }

    public function excluir(int $id): void
    {
        $this->marcas->excluir($id);
    }
}
