<?php

require_once __DIR__ . '/Modelo.php';

class ModeloRepository
{
    public function __construct(private PDO $pdo) {}

    public function listar(): array
    {
        $stmt = $this->pdo->query(
            'SELECT mo.id, mo.id_marca, mo.nome, ma.nome AS marca
             FROM modelos mo
             INNER JOIN marcas ma ON ma.id = mo.id_marca
             ORDER BY ma.nome ASC, mo.nome ASC'
        );

        return array_map([Modelo::class, 'fromArray'], $stmt->fetchAll());
    }

    public function buscarPorId(int $id): ?Modelo
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, id_marca, nome FROM modelos WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);
        $dados = $stmt->fetch();

        return $dados ? Modelo::fromArray($dados) : null;
    }

    public function listarDisponiveis(): array
    {
        $stmt = $this->pdo->query(
            'SELECT DISTINCT mo.id, mo.id_marca, mo.nome
             FROM modelos mo
             INNER JOIN veiculos v ON v.id_modelo = mo.id
             ORDER BY mo.nome ASC'
        );

        return array_map([Modelo::class, 'fromArray'], $stmt->fetchAll());
    }

    public function salvar(Modelo $modelo): void
    {
        if ($modelo->getId() !== null) {
            $stmt = $this->pdo->prepare(
                'UPDATE modelos SET id_marca = :id_marca, nome = :nome WHERE id = :id'
            );
            $stmt->execute([
                'id_marca' => $modelo->getIdMarca(),
                'nome' => $modelo->getNome(),
                'id' => $modelo->getId(),
            ]);
            return;
        }

        $stmt = $this->pdo->prepare(
            'INSERT INTO modelos (id_marca, nome) VALUES (:id_marca, :nome)'
        );
        $stmt->execute([
            'id_marca' => $modelo->getIdMarca(),
            'nome' => $modelo->getNome(),
        ]);
    }

    public function excluir(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM modelos WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function contarRelacionamentos(int $id): int
    {
        $stmt = $this->pdo->prepare(
            'SELECT COUNT(*) FROM veiculos WHERE id_modelo = :id_modelo'
        );
        $stmt->execute(['id_modelo' => $id]);

        return (int) $stmt->fetchColumn();
    }
}
