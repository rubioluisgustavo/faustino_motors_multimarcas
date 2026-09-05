<?php

require_once __DIR__ . '/Opcional.php';

class OpcionalRepository
{
    public function __construct(private PDO $pdo) {}

    public function listar(): array
    {
        $stmt = $this->pdo->query('SELECT id, nome FROM opcionais ORDER BY nome ASC');
        return array_map([Opcional::class, 'fromArray'], $stmt->fetchAll());
    }

    public function buscarPorId(int $id): ?Opcional
    {
        $stmt = $this->pdo->prepare('SELECT id, nome FROM opcionais WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $dados = $stmt->fetch();
        return $dados ? Opcional::fromArray($dados) : null;
    }

    public function salvar(Opcional $opcional): void
    {
        if ($opcional->getId() !== null) {
            $stmt = $this->pdo->prepare(
                'UPDATE opcionais SET nome = :nome WHERE id = :id'
            );
            $stmt->execute(['nome' => $opcional->getNome(), 'id' => $opcional->getId()]);
            return;
        }

        $stmt = $this->pdo->prepare('INSERT INTO opcionais (nome) VALUES (:nome)');
        $stmt->execute(['nome' => $opcional->getNome()]);
    }

    public function excluir(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM opcionais WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function contarRelacionamentos(int $id): int
    {
        $stmt = $this->pdo->prepare(
            'SELECT COUNT(*) FROM veiculos_opcionais WHERE id_opcionais = :id_opcional'
        );
        $stmt->execute(['id_opcional' => $id]);

        return (int) $stmt->fetchColumn();
    }
}
