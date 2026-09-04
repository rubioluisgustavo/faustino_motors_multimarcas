<?php

namespace App\Controllers;

use App\Repositories\MarcaRepository;
use App\Repositories\ModeloRepository;
use App\Repositories\OpcionalRepository;
use App\Repositories\VeiculoRepository;
use PDO;

class SiteController
{
    private MarcaRepository $marcaRepository;
    private ModeloRepository $modeloRepository;
    private OpcionalRepository $opcionalRepository;
    private VeiculoRepository $veiculoRepository;

    public function __construct(PDO $pdo)
    {
        $this->marcaRepository = new MarcaRepository($pdo);
        $this->modeloRepository = new ModeloRepository($pdo);
        $this->opcionalRepository = new OpcionalRepository($pdo);
        $this->veiculoRepository = new VeiculoRepository($pdo);
    }

    public function filtros(): array
    {
        $modelos = $this->modeloRepository->listarComVeiculos();

        return [
            'marcas' => $this->marcaRepository->listarComVeiculos(),
            'modelos' => $modelos,
            'modelosJson' => array_map(
                fn ($modelo): array => $modelo->toArray(),
                $modelos
            ),
        ];
    }

    public function estoque(array $query): array
    {
        return [
            'veiculos' => $this->veiculoRepository->filtrar(
                $this->inteiroOuNulo($query['marca'] ?? null),
                $this->inteiroOuNulo($query['modelo'] ?? null),
                $this->inteiroOuNulo($query['ano'] ?? null)
            ),
        ];
    }

    public function detalhes(int $id): ?array
    {
        $veiculo = $this->veiculoRepository->buscarDetalhesPorId($id);

        if ($veiculo === null) {
            return null;
        }

        return [
            'veiculo' => $veiculo,
            'opcionais' => $this->opcionalRepository->listarPorVeiculo($id),
        ];
    }

    private function inteiroOuNulo($valor): ?int
    {
        if ($valor === null || $valor === '') {
            return null;
        }

        return filter_var($valor, FILTER_VALIDATE_INT) !== false ? (int) $valor : null;
    }
}
