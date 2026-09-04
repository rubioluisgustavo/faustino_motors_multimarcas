<?php

namespace App\Models;

class Veiculo
{
    private ?int $id;
    private ?int $idModelo;
    private ?int $ano;
    private ?int $km;
    private string $cambio;
    private string $combustivel;
    private float $valor;
    private ?string $imagemPrincipal;
    private string $descricao;
    private string $novo;
    private string $marcaNome;
    private string $modeloNome;

    public function __construct(
        ?int $id = null,
        ?int $idModelo = null,
        ?int $ano = null,
        ?int $km = null,
        string $cambio = '',
        string $combustivel = '',
        float $valor = 0.0,
        ?string $imagemPrincipal = null,
        string $descricao = '',
        string $novo = 'n',
        string $marcaNome = '',
        string $modeloNome = ''
    ) {
        $this->id = $id;
        $this->idModelo = $idModelo;
        $this->ano = $ano;
        $this->km = $km;
        $this->cambio = trim($cambio);
        $this->combustivel = trim($combustivel);
        $this->valor = $valor;
        $this->imagemPrincipal = $imagemPrincipal ?: null;
        $this->descricao = trim($descricao);
        $this->novo = $novo === 'y' ? 'y' : 'n';
        $this->marcaNome = trim($marcaNome);
        $this->modeloNome = trim($modeloNome);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdModelo(): ?int
    {
        return $this->idModelo;
    }

    public function getAno(): ?int
    {
        return $this->ano;
    }

    public function getKm(): ?int
    {
        return $this->km;
    }

    public function getCambio(): string
    {
        return $this->cambio;
    }

    public function getCombustivel(): string
    {
        return $this->combustivel;
    }

    public function getValor(): float
    {
        return $this->valor;
    }

    public function getImagemPrincipal(): ?string
    {
        return $this->imagemPrincipal;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getNovo(): string
    {
        return $this->novo;
    }

    public function isNovo(): bool
    {
        return $this->novo === 'y';
    }

    public function getMarcaNome(): string
    {
        return $this->marcaNome;
    }

    public function getModeloNome(): string
    {
        return $this->modeloNome;
    }

    public function getNomeCompleto(): string
    {
        return trim($this->marcaNome . ' ' . $this->modeloNome);
    }

    public static function fromArray(array $dados): self
    {
        return new self(
            self::intOrNull($dados['id'] ?? null),
            self::intOrNull($dados['id_modelo'] ?? null),
            self::intOrNull($dados['ano'] ?? null),
            self::intOrNull($dados['km'] ?? null),
            $dados['cambio'] ?? '',
            $dados['combustivel'] ?? '',
            self::floatOrZero($dados['valor'] ?? null),
            $dados['imagem_principal'] ?? null,
            $dados['descricao'] ?? '',
            $dados['novo'] ?? 'n',
            $dados['marca'] ?? '',
            $dados['modelo'] ?? ''
        );
    }

    public static function fromPost(array $dados, ?string $imagemPrincipal = null): self
    {
        return new self(
            self::intOrNull($dados['id'] ?? null),
            self::intOrNull($dados['id_modelo'] ?? null),
            self::intOrNull($dados['ano'] ?? null),
            self::intOrNull($dados['km'] ?? null),
            $dados['cambio'] ?? '',
            $dados['combustivel'] ?? '',
            self::valorFormularioParaFloat($dados['valor'] ?? ''),
            $imagemPrincipal,
            $dados['descricao'] ?? '',
            isset($dados['novo']) && $dados['novo'] === 'y' ? 'y' : 'n'
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'id_modelo' => $this->idModelo,
            'ano' => $this->ano,
            'km' => $this->km,
            'cambio' => $this->cambio,
            'combustivel' => $this->combustivel,
            'valor' => $this->valor,
            'imagem_principal' => $this->imagemPrincipal,
            'descricao' => $this->descricao,
            'novo' => $this->novo,
            'marca' => $this->marcaNome,
            'modelo' => $this->modeloNome,
        ];
    }

    private static function intOrNull($valor): ?int
    {
        if ($valor === null || $valor === '') {
            return null;
        }

        return (int) $valor;
    }

    private static function floatOrZero($valor): float
    {
        if ($valor === null || $valor === '') {
            return 0.0;
        }

        return (float) $valor;
    }

    private static function valorFormularioParaFloat(string $valor): float
    {
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);

        return self::floatOrZero($valor);
    }
}
