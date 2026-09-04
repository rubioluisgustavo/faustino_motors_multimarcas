<?php

class Venda
{
    private ?int $id;
    private string $nome;
    private ?string $imagemPrincipal;
    private string $depoimento;

    public function __construct(array $dados = [])
    {
        $this->id = isset($dados['id']) ? (int) $dados['id'] : null;
        $this->nome = trim($dados['nome'] ?? '');
        $this->imagemPrincipal = $dados['imagem_principal'] ?? null;
        $this->depoimento = trim($dados['depoimento'] ?? '');
    }

    public static function fromArray(array $dados): self
    {
        return new self($dados);
    }

    public function getId(): ?int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function getImagemPrincipal(): ?string { return $this->imagemPrincipal; }
    public function getDepoimento(): string { return $this->depoimento; }
}
