<?php

namespace App\Repositories;

use App\Models\Modelo;
use PDO;

class ModeloRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listar(): array
    {
        $sql = $this->pdo->query(
            'SELECT mo.id, mo.id_marca, ma.nome AS marca, mo.nome
             FROM modelos mo
             INNER JOIN marcas ma ON ma.id = mo.id_marca
             ORDER BY ma.nome ASC, mo.nome ASC'
        );

        return $this->mapearModelos($sql->fetchAll());
    }

    public function listarComVeiculos(): array
    {
        $sql = $this->pdo->query(
            'SELECT DISTINCT mo.id, mo.id_marca, mo.nome
             FROM modelos mo
             INNER JOIN veiculos v ON v.id_modelo = mo.id
             ORDER BY mo.nome ASC'
        );

        return $this->mapearModelos($sql->fetchAll());
    }

    public function buscarPorId(int $id): ?Modelo
    {
        $sql = $this->pdo->prepare(
            'SELECT mo.id, mo.id_marca, ma.nome AS marca, mo.nome
             FROM modelos mo
             INNER JOIN marcas ma ON ma.id = mo.id_marca
             WHERE mo.id = :id'
        );
        $sql->execute(['id' => $id]);

        $modelo = $sql->fetch();

        if (!$modelo) {
            return null;
        }

        return Modelo::fromArray($modelo);
    }

    public function salvar(Modelo $modelo): void
    {
        if ($modelo->getId() !== null) {
            $sql = $this->pdo->prepare(
                'UPDATE modelos SET id_marca = :id_marca, nome = :nome WHERE id = :id'
            );

            $sql->execute([
                'id_marca' => $modelo->getIdMarca(),
                'nome' => $modelo->getNome(),
                'id' => $modelo->getId(),
            ]);

            return;
        }

        $sql = $this->pdo->prepare(
            'INSERT INTO modelos (id_marca, nome) VALUES (:id_marca, :nome)'
        );

        $sql->execute([
            'id_marca' => $modelo->getIdMarca(),
            'nome' => $modelo->getNome(),
        ]);
    }

    public function excluir(int $id): void
    {
        $sql = $this->pdo->prepare('DELETE FROM modelos WHERE id = :id');
        $sql->execute(['id' => $id]);
    }

    private function mapearModelos(array $dados): array
    {
        return array_map(
            fn (array $modeloData): Modelo => Modelo::fromArray($modeloData),
            $dados
        );
    }
}
