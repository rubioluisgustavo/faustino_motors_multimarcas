<?php

namespace App;

use App\Controllers\Admin\AuthController;
use App\Controllers\Admin\MarcaController;
use App\Controllers\Admin\ModeloController;
use App\Controllers\Admin\OpcionalController;
use App\Controllers\Admin\VeiculoController;
use App\Controllers\SiteController;
use PDO;

class Router
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = $this->path($uri);

        if ($this->isAdminPath($path)) {
            $this->dispatchAdmin($method, $path);
            return;
        }

        $this->dispatchSite($path);
    }

    private function dispatchSite(string $path): void
    {
        $controller = new SiteController($this->pdo);
        $idVeiculo = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (preg_match('#^/veiculo/(\d+)$#', $path, $matches)) {
            $idVeiculo = (int) $matches[1];
        }

        if ($idVeiculo) {
            $detalhes = $controller->detalhes($idVeiculo);

            if ($detalhes === null) {
                \redirect('');
            }

            $this->renderSite('site/detalhe', $detalhes);
            return;
        }

        if ($path === '/empresa' || ($_GET['menu'] ?? null) === 'empresa') {
            $this->renderSite('site/empresa');
            return;
        }

        if ($path === '/' || $path === '/veiculos') {
            $this->renderSite(
                'site/estoque',
                $controller->estoque($_GET),
                $controller->filtros()
            );
            return;
        }

        http_response_code(404);
        echo 'Pagina nao encontrada.';
    }

    private function dispatchAdmin(string $method, string $path): void
    {
        if ($path === '/admin/login' || $path === '/admin/login/index') {
            $this->login($method);
            return;
        }

        if ($path === '/admin/login/autenticar' && $method === 'POST') {
            $this->login($method);
            return;
        }

        if ($path === '/admin/logout' || $path === '/admin/login/sair') {
            $this->logout();
            return;
        }

        $this->requireAdmin();

        if ($path === '/admin' || $path === '/admin/index') {
            \view('admin/layout', [
                'titulo' => 'Painel Administrativo',
                'conteudo' => 'admin/dashboard',
            ]);
            return;
        }

        if ($this->resource('marcas', $method, $path, new MarcaController($this->pdo))) {
            return;
        }

        if ($this->resource('modelos', $method, $path, new ModeloController($this->pdo))) {
            return;
        }

        if ($this->resource('opcionais', $method, $path, new OpcionalController($this->pdo))) {
            return;
        }

        if ($this->resource('veiculos', $method, $path, new VeiculoController($this->pdo))) {
            return;
        }

        http_response_code(404);
        echo 'Pagina nao encontrada.';
    }

    private function resource(string $nome, string $method, string $path, object $controller): bool
    {
        $base = '/admin/' . $nome;

        if (($path === $base || $path === $base . '/index') && $method === 'GET') {
            if (isset($_GET['excluir'])) {
                $controller->excluir((int) $_GET['excluir']);
                \redirect('admin/' . $nome);
            }

            \view('admin/layout', [
                'titulo' => ucfirst($nome),
                'conteudo' => 'admin/' . $nome . '/index',
                'dados' => $controller->index(),
            ]);
            return true;
        }

        if (($path === $base || $path === $base . '/salvar') && $method === 'POST') {
            $nome === 'veiculos'
                ? $controller->salvar($_POST, $_FILES)
                : $controller->salvar($_POST);

            \redirect('admin/' . $nome);
        }

        if ($path === $base . '/cadastro' && $method === 'GET') {
            \view('admin/layout', [
                'titulo' => 'Cadastro de ' . ucfirst(rtrim($nome, 's')),
                'conteudo' => 'admin/' . $nome . '/form',
                'dados' => $controller->form(isset($_GET['id']) ? (int) $_GET['id'] : null),
            ]);
            return true;
        }

        if (preg_match('#^' . preg_quote($base, '#') . '/excluir/(\d+)$#', $path, $matches) && $method === 'GET') {
            $controller->excluir((int) $matches[1]);
            \redirect('admin/' . $nome);
        }

        return false;
    }

    private function login(string $method): void
    {
        $this->startSession();

        if (isset($_SESSION['usuario'])) {
            \redirect('admin');
        }

        if ($method === 'POST') {
            $controller = new AuthController($this->pdo);

            if ($controller->autenticar($_POST['email'] ?? '', $_POST['senha'] ?? '')) {
                \redirect('admin');
            }

            \redirect('admin/login?erro=1');
        }

        \view('admin/login', [
            'erro' => isset($_GET['erro']),
        ]);
    }

    private function logout(): void
    {
        $this->startSession();
        session_destroy();

        \redirect('admin/login');
    }

    private function requireAdmin(): void
    {
        $this->startSession();

        if (!isset($_SESSION['usuario'])) {
            \redirect('admin/login');
        }
    }

    private function startSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    private function renderSite(string $conteudo, array $dadosConteudo = [], array $dadosFiltro = []): void
    {
        \view('site/layout', [
            'conteudo' => $conteudo,
            'dadosConteudo' => $dadosConteudo,
            'dadosFiltro' => $dadosFiltro,
            'exibirFiltro' => !empty($dadosFiltro),
        ]);
    }

    private function path(string $uri): string
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $base = \app_base_url();

        if ($base !== '' && str_starts_with($path, $base)) {
            $path = substr($path, strlen($base)) ?: '/';
        }

        $path = preg_replace('#/index\.php$#', '/', $path);
        $path = preg_replace('#\.php$#', '', $path);
        $path = '/' . trim($path, '/');

        return $path === '/' ? '/' : rtrim($path, '/');
    }

    private function isAdminPath(string $path): bool
    {
        return $path === '/admin' || str_starts_with($path, '/admin/');
    }
}
