<?php

function storeUploadedImage(
    string $temporaryPath,
    string $originalName,
    string $targetDirectory,
    string $relativeDirectory
): string {
    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $allowedTypes = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'webp' => 'image/webp',
    ];
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($temporaryPath);

    if (!isset($allowedTypes[$extension]) || $allowedTypes[$extension] !== $mime) {
        throw new RuntimeException('Formato de imagem não permitido.');
    }

    if (!is_dir($targetDirectory) && !mkdir($targetDirectory, 0755, true)) {
        throw new RuntimeException('Não foi possível preparar a pasta de imagens.');
    }

    $fileName = bin2hex(random_bytes(16)) . '.' . $extension;
    $destination = rtrim($targetDirectory, '/\\') . DIRECTORY_SEPARATOR . $fileName;
    if (!move_uploaded_file($temporaryPath, $destination)) {
        throw new RuntimeException('Não foi possível salvar a imagem.');
    }

    return trim($relativeDirectory, '/') . '/' . $fileName;
}
