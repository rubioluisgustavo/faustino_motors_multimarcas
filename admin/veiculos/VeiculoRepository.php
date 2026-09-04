<?php

require_once __DIR__ . '/Veiculo.php';
require_once __DIR__ . '/../opcionais/Opcional.php';

class VeiculoRepository
{
    public function __construct(private PDO $pdo) {}

    private function baseQuery(): string
    {
        return 'SELECT v.id, v.id_modelo, ma.nome AS marca, mo.nome AS modelo,
                       v.ano, v.km, v.cambio, v.combustivel, v.valor, v.valor_premium,
                       v.imagem_principal, v.descricao, v.novo
                FROM veiculos v
                INNER JOIN modelos mo ON mo.id = v.id_modelo
                INNER JOIN marcas ma ON ma.id = mo.id_marca';
    }

    public function listar(array $filtros = []): array
    {
        $sql = $this->baseQuery() . ' WHERE 1 = 1';
        $params = [];
        foreach (['marca' => 'ma.id', 'modelo' => 'mo.id', 'ano' => 'v.ano'] as $chave => $campo) {
            if (($filtros[$chave] ?? '') !== '') {
                $sql .= " AND {$campo} = ?";
                $params[] = $filtros[$chave];
            }
        }
        $sql .= ' ORDER BY v.id DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return array_map([Veiculo::class, 'fromArray'], $stmt->fetchAll());
    }

    public function buscarPorId(int $id): ?Veiculo
    {
        $stmt = $this->pdo->prepare($this->baseQuery() . ' WHERE v.id = ? LIMIT 1');
        $stmt->execute([$id]);
        $dados = $stmt->fetch();
        return $dados ? Veiculo::fromArray($dados) : null;
    }

    public function listarOpcionais(int $idVeiculo): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT o.id, o.nome FROM veiculos_opcionais vo
             INNER JOIN opcionais o ON o.id = vo.id_opcionais
             WHERE vo.id_veiculo = ? ORDER BY o.nome ASC'
        );
        $stmt->execute([$idVeiculo]);
        return array_map([Opcional::class, 'fromArray'], $stmt->fetchAll());
    }
}
