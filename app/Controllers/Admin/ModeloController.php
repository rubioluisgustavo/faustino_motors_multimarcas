<?php

namespace App\Controllers\Admin;

use App\Models\Modelo;
use App\Repositories\MarcaRepository;
use App\Repositories\ModeloRepository;
use PDO;

class ModeloController
{
    private ModeloRepository $modelos;
    private MarcaRepository $marcas;

    public function __construct(PDO $pdo)
    {
        $this->modelos = new ModeloRepository($pdo);
        $this->marcas = new MarcaRepository($pdo);
    }

    public function index(): array
    {
        return ['modelos' => $this->modelos->listar()];
    }

    public function form(?int $id): array
    {
        $modelo = new Modelo();

        if ($id !== null) {
            $modelo = $this->modelos->buscarPorId($id) ?? $modelo;
        }

        return [
            'modelo' => $modelo,
            'marcas' => $this->marcas->listar(),
        ];
    }

    public function salvar(array $dados): void
    {
        $id = isset($dados['id']) && $dados['id'] !== '' ? (int) $dados['id'] : null;
        $idMarca = isset($dados['id_marca']) && $dados['id_marca'] !== '' ? (int) $dados['id_marca'] : null;
        $nome = trim($dados['nome'] ?? '');

        if ($idMarca === null || $nome === '') {
            redirect('admin/modelos/cadastro' . ($id ? '?id=' . $id : ''));
        }

        $this->modelos->salvar(new Modelo($id, $idMarca, $nome));
    }

    public function excluir(int $id): void
    {
        $this->modelos->excluir($id);
    }
}
