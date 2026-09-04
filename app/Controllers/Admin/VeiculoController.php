<?php

namespace App\Controllers\Admin;

use App\Models\Veiculo;
use App\Repositories\ModeloRepository;
use App\Repositories\OpcionalRepository;
use App\Repositories\VeiculoRepository;
use App\Services\ImagemVeiculoUploader;
use PDO;

class VeiculoController
{
    private VeiculoRepository $veiculos;
    private ModeloRepository $modelos;
    private OpcionalRepository $opcionais;

    public function __construct(PDO $pdo)
    {
        $this->veiculos = new VeiculoRepository($pdo);
        $this->modelos = new ModeloRepository($pdo);
        $this->opcionais = new OpcionalRepository($pdo);
    }

    public function index(): array
    {
        return ['veiculos' => $this->veiculos->listarAdmin()];
    }

    public function form(?int $id): array
    {
        $veiculo = new Veiculo();
        $opcionaisSelecionados = [];

        if ($id !== null) {
            $veiculo = $this->veiculos->buscarPorId($id) ?? $veiculo;
            $opcionaisSelecionados = $this->opcionais->listarIdsPorVeiculo($id);
        }

        return [
            'veiculo' => $veiculo,
            'valor' => $veiculo->getValor() > 0 ? number_format($veiculo->getValor(), 2, ',', '.') : '',
            'modelos' => $this->modelos->listar(),
            'opcionais' => $this->opcionais->listar(),
            'opcionaisSelecionados' => $opcionaisSelecionados,
        ];
    }

    public function salvar(array $dados, array $arquivos): void
    {
        $uploader = new ImagemVeiculoUploader(
            __DIR__ . '/../../../public/img/carros',
            'public/img/carros'
        );

        $imagem = $uploader->upload($arquivos['imagem_principal'] ?? []);
        $veiculo = Veiculo::fromPost($dados, $imagem);

        $this->veiculos->salvarComOpcionais($veiculo, $dados['opcionais'] ?? []);
    }

    public function excluir(int $id): void
    {
        $this->veiculos->excluir($id);
    }
}
