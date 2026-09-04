<?php

require_once __DIR__ . '/Marca.php';

class MarcaRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listar(): array
    {
        $sql = $this->pdo->query(
            'SELECT id, nome FROM marcas ORDER BY nome ASC'
        );

        $marcas = [];

        foreach ($sql->fetchAll() as $marcaData) {
            $marcas[] = Marca::fromArray($marcaData);
        }

        return $marcas;
    }

    public function listarDisponiveis(): array
    {
        $sql = $this->pdo->query(
            'SELECT DISTINCT ma.id, ma.nome
             FROM marcas ma
             INNER JOIN modelos mo ON mo.id_marca = ma.id
             INNER JOIN veiculos v ON v.id_modelo = mo.id
             ORDER BY ma.nome ASC'
        );

        return array_map([Marca::class, 'fromArray'], $sql->fetchAll());
    }

    public function buscarPorId(int $id): ?Marca
    {
        $sql = $this->pdo->prepare('SELECT id, nome FROM marcas WHERE id = :id');
        $sql->execute(['id' => $id]);

        $marca = $sql->fetch();

        if (!$marca) {
            return null;
        }

        return Marca::fromArray($marca);
    }

    public function salvar(Marca $marca): void
    {
        if ($marca->getId() !== null) {
            $sql = $this->pdo->prepare(
                'UPDATE marcas SET nome = :nome WHERE id = :id'
            );

            $sql->execute([
                'nome' => $marca->getNome(),
                'id' => $marca->getId(),
            ]);

            return;
        }

        $sql = $this->pdo->prepare(
            'INSERT INTO marcas (nome) VALUES (:nome)'
        );

        $sql->execute([
            'nome' => $marca->getNome(),
        ]);
    }

    public function excluir(int $id): void
    {
        $sql = $this->pdo->prepare('DELETE FROM marcas WHERE id = :id');
        $sql->execute(['id' => $id]);
    }
}
