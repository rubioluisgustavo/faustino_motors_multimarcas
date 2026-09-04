<?php

namespace App\Repositories;

use App\Models\Usuario;
use PDO;

class UsuarioRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarPorEmail(string $email): ?Usuario
    {
        $sql = $this->pdo->prepare(
            'SELECT id, nome, email, senha FROM usuarios WHERE email = :email LIMIT 1'
        );
        $sql->execute(['email' => trim($email)]);

        $usuario = $sql->fetch();

        if (!$usuario) {
            return null;
        }

        return Usuario::fromArray($usuario);
    }

    public function autenticar(string $email, string $senha): ?Usuario
    {
        $usuario = $this->buscarPorEmail($email);

        if ($usuario === null || !$usuario->verificarSenha($senha)) {
            return null;
        }

        return $usuario;
    }
}
