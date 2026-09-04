<?php

class Veiculo
{
    private ?int $id;
    private ?int $idModelo;
    private string $marca;
    private string $modelo;
    private int $ano;
    private float $km;
    private string $cambio;
    private string $combustivel;
    private float $valor;
    private ?float $valorPremium;
    private ?string $imagemPrincipal;
    private string $descricao;
    private string $novo;

    public function __construct(array $dados = [])
    {
        $this->id = isset($dados['id']) ? (int) $dados['id'] : null;
        $this->idModelo = isset($dados['id_modelo']) ? (int) $dados['id_modelo'] : null;
        $this->marca = $dados['marca'] ?? '';
        $this->modelo = $dados['modelo'] ?? '';
        $this->ano = (int) ($dados['ano'] ?? 0);
        $this->km = (float) ($dados['km'] ?? 0);
        $this->cambio = $dados['cambio'] ?? '';
        $this->combustivel = $dados['combustivel'] ?? '';
        $this->valor = (float) ($dados['valor'] ?? 0);
        $this->valorPremium = isset($dados['valor_premium']) && $dados['valor_premium'] !== ''
            ? (float) $dados['valor_premium']
            : null;
        $this->imagemPrincipal = $dados['imagem_principal'] ?? null;
        $this->descricao = $dados['descricao'] ?? '';
        $this->novo = $dados['novo'] ?? 'n';
    }

    public static function fromArray(array $dados): self { return new self($dados); }
    public function getId(): ?int { return $this->id; }
    public function getIdModelo(): ?int { return $this->idModelo; }
    public function getMarca(): string { return $this->marca; }
    public function getModelo(): string { return $this->modelo; }
    public function getAno(): int { return $this->ano; }
    public function getKm(): float { return $this->km; }
    public function getCambio(): string { return $this->cambio; }
    public function getCombustivel(): string { return $this->combustivel; }
    public function getValor(): float { return $this->valor; }
    public function getValorPremium(): ?float { return $this->valorPremium; }
    public function getImagemPrincipal(): ?string { return $this->imagemPrincipal; }
    public function getDescricao(): string { return $this->descricao; }
    public function isNovo(): bool { return $this->novo === 'y'; }
}
