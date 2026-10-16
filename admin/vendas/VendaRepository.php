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

        $vendas = $stmt->fetchAll();
        if (!$vendas) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($vendas), '?'));
        $imagensStmt = $this->pdo->prepare(
            "SELECT id_venda, imagem FROM venda_imagens
             WHERE id_venda IN ($placeholders) ORDER BY id ASC"
        );
        $imagensStmt->execute(array_column($vendas, 'id'));
        $imagensPorVenda = [];
        foreach ($imagensStmt->fetchAll() as $imagem) {
            $imagensPorVenda[$imagem['id_venda']][] = $imagem['imagem'];
        }

        foreach ($vendas as &$venda) {
            $venda['imagens'] = $imagensPorVenda[$venda['id']] ?? [];
        }
        unset($venda);

        return array_map([Venda::class, 'fromArray'], $vendas);
    }

    public function buscarPorId(int $id): ?Venda
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, nome, imagem_principal, depoimento
             FROM vendas WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);
        $dados = $stmt->fetch();

        if (!$dados) {
            return null;
        }

        $imagensStmt = $this->pdo->prepare(
            'SELECT imagem FROM venda_imagens WHERE id_venda = ? ORDER BY id ASC'
        );
        $imagensStmt->execute([$id]);
        $dados['imagens'] = array_column($imagensStmt->fetchAll(), 'imagem');

        return Venda::fromArray($dados);
    }

    public function salvar(Venda $venda, ?string $imagem = null): int
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
            return $venda->getId() ?? throw new LogicException('O ID da venda não foi definido.');
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
        return (int) $this->pdo->lastInsertId();
    }

    public function excluir(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM vendas WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function adicionarImagens(int $idVenda, array $imagens): void
    {
        if (!$imagens) {
            return;
        }

        $stmt = $this->pdo->prepare(
            'INSERT INTO venda_imagens (id_venda, imagem) VALUES (:id_venda, :imagem)'
        );
        foreach ($imagens as $imagem) {
            $stmt->execute(['id_venda' => $idVenda, 'imagem' => $imagem]);
        }
    }
}
