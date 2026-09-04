<?php

function e($valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

function dinheiro(float $valor): string
{
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

function numero($valor): string
{
    return number_format((int) $valor, 0, ',', '.');
}

function app_base_url(): string
{
    $documentRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '') ?: '';
    $projectRoot = realpath(__DIR__ . '/../..') ?: '';

    $documentRoot = str_replace('\\', '/', $documentRoot);
    $projectRoot = str_replace('\\', '/', $projectRoot);

    if ($documentRoot !== '' && str_starts_with($projectRoot, $documentRoot)) {
        $base = substr($projectRoot, strlen($documentRoot));
        $base = trim($base, '/');

        return $base === '' ? '' : '/' . $base;
    }

    $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $base = preg_replace('#/(admin|app|components|models|public)(/.*)?$#', '', dirname($scriptName));
    $base = rtrim(str_replace('/index.php', '', $base), '/');

    return $base === '' ? '' : $base;
}

function url(string $path = ''): string
{
    $path = ltrim($path, '/');

    return app_base_url() . ($path !== '' ? '/' . $path : '/');
}

function asset(string $path): string
{
    return url($path);
}

function selected($atual, $esperado): string
{
    return (string) $atual === (string) $esperado ? 'selected' : '';
}

function checked(bool $condicao): string
{
    return $condicao ? 'checked' : '';
}

function view(string $template, array $data = []): void
{
    extract($data, EXTR_SKIP);
    include __DIR__ . '/../Views/' . trim($template, '/\\') . '.php';
}

function redirect(string $path): void
{
    header('Location: ' . url($path));
    exit;
}
