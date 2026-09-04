<?php

namespace App\Models;

class Usuario
{
    private int $id;
    private string $nome;
    private string $email;
    private string $senhaHash;

    public function __construct(int $id, string $nome, string $email, string $senhaHash)
    {
        $this->id = $id;
        $this->nome = trim($nome);
        $this->email = trim($email);
        $this->senhaHash = $senhaHash;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function verificarSenha(string $senha): bool
    {
        return password_verify($senha, $this->senhaHash);
    }

    public static function fromArray(array $dados): self
    {
        return new self(
            (int) $dados['id'],
            $dados['nome'] ?? '',
            $dados['email'] ?? '',
            $dados['senha'] ?? ''
        );
    }
}
