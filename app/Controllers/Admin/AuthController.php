<?php

namespace App\Controllers\Admin;

use App\Repositories\UsuarioRepository;
use PDO;

class AuthController
{
    private UsuarioRepository $usuarios;

    public function __construct(PDO $pdo)
    {
        $this->usuarios = new UsuarioRepository($pdo);
    }

    public function autenticar(string $email, string $senha): bool
    {
        $usuario = $this->usuarios->autenticar($email, $senha);

        if ($usuario === null) {
            return false;
        }

        $_SESSION['usuario'] = [
            'id' => $usuario->getId(),
            'nome' => $usuario->getNome(),
        ];

        return true;
    }
}
