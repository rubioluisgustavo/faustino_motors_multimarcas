<?php

namespace App\Models;

class Opcional
{
    private ?int $id;
    private string $nome;

    public function __construct(?int $id = null, string $nome = '')
    {
        $this->id = $id;
        $this->setNome($nome);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = trim($nome);
    }

    public static function fromArray(array $dados): self
    {
        return new self(
            isset($dados['id']) && $dados['id'] !== '' ? (int) $dados['id'] : null,
            $dados['nome'] ?? ''
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
        ];
    }
}
