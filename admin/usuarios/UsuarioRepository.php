<?php

require_once __DIR__ . '/Usuario.php';

class UsuarioRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function listar(): array
    {
        $sql = $this->pdo->query('SELECT id, email FROM usuarios ORDER BY email ASC');

        return array_map([Usuario::class, 'fromArray'], $sql->fetchAll());
    }

    public function buscarPorId(int $id): ?Usuario
    {
        $sql = $this->pdo->prepare('SELECT id, email FROM usuarios WHERE id = :id');
        $sql->execute(['id' => $id]);
        $usuario = $sql->fetch();

        return $usuario ? Usuario::fromArray($usuario) : null;
    }

    public function existeEmail(string $email, ?int $id = null): bool
    {
        $sql = 'SELECT COUNT(*) FROM usuarios WHERE email = :email';
        $params = ['email' => $email];

        if ($id !== null) {
            $sql .= ' AND id <> :id';
            $params['id'] = $id;
        }

        $consulta = $this->pdo->prepare($sql);
        $consulta->execute($params);

        return (int) $consulta->fetchColumn() > 0;
    }

    public function salvar(Usuario $usuario): void
    {
        if ($usuario->getId() !== null) {
            if ($usuario->getSenha() === '') {
                $sql = $this->pdo->prepare(
                    'UPDATE usuarios SET email = :email WHERE id = :id'
                );
                $sql->execute([
                    'email' => $usuario->getEmail(),
                    'id' => $usuario->getId(),
                ]);
                return;
            }

            $sql = $this->pdo->prepare(
                'UPDATE usuarios SET email = :email, senha = :senha WHERE id = :id'
            );
            $sql->execute([
                'email' => $usuario->getEmail(),
                'senha' => password_hash($usuario->getSenha(), PASSWORD_DEFAULT),
                'id' => $usuario->getId(),
            ]);
            return;
        }

        $sql = $this->pdo->prepare(
            'INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)'
        );
        $sql->execute([
            'nome' => $usuario->getEmail(),
            'email' => $usuario->getEmail(),
            'senha' => password_hash($usuario->getSenha(), PASSWORD_DEFAULT),
        ]);
    }

    public function excluir(int $id): void
    {
        $sql = $this->pdo->prepare('DELETE FROM usuarios WHERE id = :id');
        $sql->execute(['id' => $id]);
    }
}
