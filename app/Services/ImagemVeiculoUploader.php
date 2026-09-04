<?php

namespace App\Services;

use RuntimeException;

class ImagemVeiculoUploader
{
    private string $diretorioDestino;
    private string $caminhoPublico;

    public function __construct(string $diretorioDestino, string $caminhoPublico)
    {
        $this->diretorioDestino = rtrim($diretorioDestino, '/\\') . DIRECTORY_SEPARATOR;
        $this->caminhoPublico = trim($caminhoPublico, '/\\');
    }

    public function upload(array $arquivo): ?string
    {
        if (($arquivo['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if (($arquivo['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Erro no upload da imagem.');
        }

        if (!is_dir($this->diretorioDestino)) {
            mkdir($this->diretorioDestino, 0777, true);
        }

        $extensao = strtolower(pathinfo($arquivo['name'] ?? '', PATHINFO_EXTENSION));
        $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array($extensao, $extensoesPermitidas, true)) {
            throw new RuntimeException('Formato de imagem invalido.');
        }

        if (!is_uploaded_file($arquivo['tmp_name']) || getimagesize($arquivo['tmp_name']) === false) {
            throw new RuntimeException('O arquivo enviado nao e uma imagem valida.');
        }

        $nomeArquivo = time() . '_' . bin2hex(random_bytes(8)) . '.' . $extensao;
        $destino = $this->diretorioDestino . $nomeArquivo;

        if (!move_uploaded_file($arquivo['tmp_name'], $destino)) {
            throw new RuntimeException('Nao foi possivel salvar a imagem.');
        }

        return $this->caminhoPublico . '/' . $nomeArquivo;
    }
}
