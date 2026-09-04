<?php

namespace App\Models;

class Modelo
{
    private ?int $id;
    private ?int $idMarca;
    private string $nome;
    private string $marcaNome;

    public function __construct(
        ?int $id = null,
        ?int $idMarca = null,
        string $nome = '',
        string $marcaNome = ''
    ) {
        $this->id = $id;
        $this->idMarca = $idMarca;
        $this->setNome($nome);
        $this->marcaNome = trim($marcaNome);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMarca(): ?int
    {
        return $this->idMarca;
    }

    public function setIdMarca(?int $idMarca): void
    {
        $this->idMarca = $idMarca;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = trim($nome);
    }

    public function getMarcaNome(): string
    {
        return $this->marcaNome;
    }

    public function getNomeCompleto(): string
    {
        if ($this->marcaNome === '') {
            return $this->nome;
        }

        return $this->marcaNome . ' - ' . $this->nome;
    }

    public static function fromArray(array $dados): self
    {
        return new self(
            isset($dados['id']) && $dados['id'] !== '' ? (int) $dados['id'] : null,
            isset($dados['id_marca']) && $dados['id_marca'] !== '' ? (int) $dados['id_marca'] : null,
            $dados['nome'] ?? '',
            $dados['marca'] ?? ''
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'id_marca' => $this->idMarca,
            'nome' => $this->nome,
            'marca' => $this->marcaNome,
        ];
    }
}
