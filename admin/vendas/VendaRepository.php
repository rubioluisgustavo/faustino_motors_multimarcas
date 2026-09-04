<?php

require_once __DIR__ . '/Venda.php';

class VendaRepository
{
    public function __construct(private PDO $pdo) {}

    public function listar(): array
    {
        $stmt = $this->pdo->query(
            'SELECT id, nome, imagem_principal, depoimento
             FROM vendas
             ORDER BY id DESC'
        );

        return array_map([Venda::class, 'fromArray'], $stmt->fetchAll());
    }

    public function buscarPorId(int $id): ?Venda
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, nome, imagem_principal, depoimento
             FROM vendas WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);
        $dados = $stmt->fetch();

        return $dados ? Venda::fromArray($dados) : null;
    }

    public function salvar(Venda $venda, ?string $imagem = null): void
    {
        if ($venda->getId() !== null) {
            $sql = 'UPDATE vendas SET nome = :nome, depoimento = :depoimento';
            $params = [
                'nome' => $venda->getNome(),
                'depoimento' => $venda->getDepoimento(),
                'id' => $venda->getId(),
            ];

            if ($imagem !== null) {
                $sql .= ', imagem_principal = :imagem_principal';
                $params['imagem_principal'] = $imagem;
            }

            $stmt = $this->pdo->prepare($sql . ' WHERE id = :id');
            $stmt->execute($params);
            return;
        }

        $stmt = $this->pdo->prepare(
            'INSERT INTO vendas (nome, imagem_principal, depoimento)
             VALUES (:nome, :imagem_principal, :depoimento)'
        );
        $stmt->execute([
            'nome' => $venda->getNome(),
            'imagem_principal' => $imagem,
            'depoimento' => $venda->getDepoimento(),
        ]);
    }

    public function excluir(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM vendas WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
