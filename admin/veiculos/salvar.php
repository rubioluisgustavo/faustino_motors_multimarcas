<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../../app/bootstrap.php';

try {
    $uploader = new App\Services\ImagemVeiculoUploader(
        __DIR__ . '/../../public/img/carros',
        'public/img/carros'
    );

    $imagem = $uploader->upload($_FILES['imagem_principal'] ?? []);
    $veiculo = App\Models\Veiculo::fromPost($_POST, $imagem);
    $opcionais = $_POST['opcionais'] ?? [];

    $veiculoRepository = new App\Repositories\VeiculoRepository($pdo);
    $veiculoRepository->salvarComOpcionais($veiculo, $opcionais);

    header('Location: index.php');
    exit;
} catch (Throwable $e) {
    die('Erro ao salvar veículo: ' . $e->getMessage());
}
