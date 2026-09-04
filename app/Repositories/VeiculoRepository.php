<?php

namespace App\Repositories;

use App\Models\Veiculo;
use PDO;
use Throwable;

class VeiculoRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listarAdmin(): array
    {
        $sql = $this->pdo->query(
            'SELECT v.id, v.id_modelo, ma.nome AS marca, mo.nome AS modelo,
                    v.novo, v.ano, v.km, v.cambio, v.combustivel, v.valor,
                    v.imagem_principal, v.descricao
             FROM veiculos v
             INNER JOIN modelos mo ON mo.id = v.id_modelo
             INNER JOIN marcas ma ON ma.id = mo.id_marca
             ORDER BY v.id DESC'
        );

        return $this->mapearVeiculos($sql->fetchAll());
    }

    public function filtrar(?int $marcaId = null, ?int $modeloId = null, ?int $ano = null): array
    {
        $sql = 'SELECT v.id, v.id_modelo, ma.nome AS marca, mo.nome AS modelo,
                       v.ano, v.novo, v.km, v.cambio, v.combustivel, v.valor,
                       v.imagem_principal, v.descricao
                FROM veiculos v
                INNER JOIN modelos mo ON mo.id = v.id_modelo
                INNER JOIN marcas ma ON ma.id = mo.id_marca
                WHERE 1 = 1';

        $params = [];

        if ($marcaId !== null) {
            $sql .= ' AND ma.id = :marca';
            $params['marca'] = $marcaId;
        }

        if ($modeloId !== null) {
            $sql .= ' AND mo.id = :modelo';
            $params['modelo'] = $modeloId;
        }

        if ($ano !== null) {
            $sql .= ' AND v.ano = :ano';
            $params['ano'] = $ano;
        }

        $sql .= ' ORDER BY v.id DESC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $this->mapearVeiculos($stmt->fetchAll());
    }

    public function buscarPorId(int $id): ?Veiculo
    {
        $sql = $this->pdo->prepare('SELECT * FROM veiculos WHERE id = :id');
        $sql->execute(['id' => $id]);

        $veiculo = $sql->fetch();

        if (!$veiculo) {
            return null;
        }

        return Veiculo::fromArray($veiculo);
    }

    public function buscarDetalhesPorId(int $id): ?Veiculo
    {
        $sql = $this->pdo->prepare(
            'SELECT v.id, v.id_modelo, ma.nome AS marca, mo.nome AS modelo,
                    v.ano, v.km, v.cambio, v.combustivel, v.valor,
                    v.imagem_principal, v.descricao, v.novo
             FROM veiculos v
             INNER JOIN modelos mo ON mo.id = v.id_modelo
             INNER JOIN marcas ma ON ma.id = mo.id_marca
             WHERE v.id = :id
             LIMIT 1'
        );
        $sql->execute(['id' => $id]);

        $veiculo = $sql->fetch();

        if (!$veiculo) {
            return null;
        }

        return Veiculo::fromArray($veiculo);
    }

    public function salvarComOpcionais(Veiculo $veiculo, array $opcionais): int
    {
        $this->pdo->beginTransaction();

        try {
            $idVeiculo = $this->salvar($veiculo);
            $this->salvarOpcionais($idVeiculo, $opcionais);
            $this->pdo->commit();

            return $idVeiculo;
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function salvar(Veiculo $veiculo): int
    {
        if ($veiculo->getId() !== null) {
            return $this->atualizar($veiculo);
        }

        $sql = $this->pdo->prepare(
            'INSERT INTO veiculos
                (id_modelo, ano, km, cambio, combustivel, valor, imagem_principal, descricao, novo)
             VALUES
                (:id_modelo, :ano, :km, :cambio, :combustivel, :valor, :imagem_principal, :descricao, :novo)'
        );

        $sql->execute([
            'id_modelo' => $veiculo->getIdModelo(),
            'ano' => $veiculo->getAno(),
            'km' => $veiculo->getKm(),
            'cambio' => $veiculo->getCambio(),
            'combustivel' => $veiculo->getCombustivel(),
            'valor' => $veiculo->getValor(),
            'imagem_principal' => $veiculo->getImagemPrincipal(),
            'descricao' => $veiculo->getDescricao(),
            'novo' => $veiculo->getNovo(),
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function excluir(int $id): void
    {
        $this->pdo->beginTransaction();

        try {
            $sql = $this->pdo->prepare('DELETE FROM veiculos_opcionais WHERE id_veiculo = :id');
            $sql->execute(['id' => $id]);

            $sql = $this->pdo->prepare('DELETE FROM veiculos WHERE id = :id');
            $sql->execute(['id' => $id]);

            $this->pdo->commit();
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    private function atualizar(Veiculo $veiculo): int
    {
        $campos = [
            'id_modelo = :id_modelo',
            'ano = :ano',
            'km = :km',
            'cambio = :cambio',
            'combustivel = :combustivel',
            'valor = :valor',
            'descricao = :descricao',
            'novo = :novo',
        ];

        $params = [
            'id_modelo' => $veiculo->getIdModelo(),
            'ano' => $veiculo->getAno(),
            'km' => $veiculo->getKm(),
            'cambio' => $veiculo->getCambio(),
            'combustivel' => $veiculo->getCombustivel(),
            'valor' => $veiculo->getValor(),
            'descricao' => $veiculo->getDescricao(),
            'novo' => $veiculo->getNovo(),
            'id' => $veiculo->getId(),
        ];

        if ($veiculo->getImagemPrincipal() !== null) {
            $campos[] = 'imagem_principal = :imagem_principal';
            $params['imagem_principal'] = $veiculo->getImagemPrincipal();
        }

        $sql = $this->pdo->prepare(
            'UPDATE veiculos SET ' . implode(', ', $campos) . ' WHERE id = :id'
        );
        $sql->execute($params);

        return (int) $veiculo->getId();
    }

    private function salvarOpcionais(int $idVeiculo, array $opcionais): void
    {
        $sql = $this->pdo->prepare('DELETE FROM veiculos_opcionais WHERE id_veiculo = :id_veiculo');
        $sql->execute(['id_veiculo' => $idVeiculo]);

        $ids = array_values(array_unique(array_filter(array_map('intval', $opcionais))));

        if (empty($ids)) {
            return;
        }

        $sql = $this->pdo->prepare(
            'INSERT INTO veiculos_opcionais (id_veiculo, id_opcionais)
             VALUES (:id_veiculo, :id_opcionais)'
        );

        foreach ($ids as $idOpcional) {
            $sql->execute([
                'id_veiculo' => $idVeiculo,
                'id_opcionais' => $idOpcional,
            ]);
        }
    }

    private function mapearVeiculos(array $dados): array
    {
        return array_map(
            fn (array $veiculoData): Veiculo => Veiculo::fromArray($veiculoData),
            $dados
        );
    }
}
