<?php

namespace App\Repositories;

use App\Models\Opcional;
use PDO;

class OpcionalRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listar(): array
    {
        $sql = $this->pdo->query('SELECT id, nome FROM opcionais ORDER BY nome ASC');

        return $this->mapearOpcionais($sql->fetchAll());
    }

    public function buscarPorId(int $id): ?Opcional
    {
        $sql = $this->pdo->prepare('SELECT id, nome FROM opcionais WHERE id = :id');
        $sql->execute(['id' => $id]);

        $opcional = $sql->fetch();

        if (!$opcional) {
            return null;
        }

        return Opcional::fromArray($opcional);
    }

    public function listarPorVeiculo(int $idVeiculo): array
    {
        $sql = $this->pdo->prepare(
            'SELECT o.id, o.nome
             FROM veiculos_opcionais vo
             INNER JOIN opcionais o ON o.id = vo.id_opcionais
             WHERE vo.id_veiculo = :id_veiculo
             ORDER BY o.nome ASC'
        );
        $sql->execute(['id_veiculo' => $idVeiculo]);

        return $this->mapearOpcionais($sql->fetchAll());
    }

    public function listarIdsPorVeiculo(int $idVeiculo): array
    {
        $sql = $this->pdo->prepare(
            'SELECT id_opcionais FROM veiculos_opcionais WHERE id_veiculo = :id_veiculo'
        );
        $sql->execute(['id_veiculo' => $idVeiculo]);

        return array_map('intval', $sql->fetchAll(PDO::FETCH_COLUMN));
    }

    public function salvar(Opcional $opcional): void
    {
        if ($opcional->getId() !== null) {
            $sql = $this->pdo->prepare(
                'UPDATE opcionais SET nome = :nome WHERE id = :id'
            );

            $sql->execute([
                'nome' => $opcional->getNome(),
                'id' => $opcional->getId(),
            ]);

            return;
        }

        $sql = $this->pdo->prepare('INSERT INTO opcionais (nome) VALUES (:nome)');
        $sql->execute(['nome' => $opcional->getNome()]);
    }

    public function excluir(int $id): void
    {
        $sql = $this->pdo->prepare('DELETE FROM opcionais WHERE id = :id');
        $sql->execute(['id' => $id]);
    }

    private function mapearOpcionais(array $dados): array
    {
        return array_map(
            fn (array $opcionalData): Opcional => Opcional::fromArray($opcionalData),
            $dados
        );
    }
}
