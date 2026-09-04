<?php

class Modelo
{
    private ?int $id;
    private ?int $idMarca;
    private string $nome;
    private string $marca;

    public function __construct(
        ?int $id = null,
        ?int $idMarca = null,
        string $nome = '',
        string $marca = ''
    ) {
        $this->id = $id;
        $this->idMarca = $idMarca;
        $this->nome = trim($nome);
        $this->marca = $marca;
    }

    public function getId(): ?int { return $this->id; }
    public function getIdMarca(): ?int { return $this->idMarca; }
    public function getNome(): string { return $this->nome; }
    public function getMarca(): string { return $this->marca; }

    public function setId(?int $id): void { $this->id = $id; }
    public function setIdMarca(?int $idMarca): void { $this->idMarca = $idMarca; }
    public function setNome(string $nome): void { $this->nome = trim($nome); }

    public static function fromArray(array $dados): self
    {
        return new self(
            isset($dados['id']) && $dados['id'] !== '' ? (int) $dados['id'] : null,
            isset($dados['id_marca']) && $dados['id_marca'] !== '' ? (int) $dados['id_marca'] : null,
            $dados['nome'] ?? '',
            $dados['marca'] ?? ''
        );
    }
}
