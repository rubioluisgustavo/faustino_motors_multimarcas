<?php

require_once __DIR__ . '/../admin/includes/auth.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (empty($_SESSION['sql_csrf_token'])) {
    $_SESSION['sql_csrf_token'] = bin2hex(random_bytes(32));
}

$mensagem = null;
$tipoMensagem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    $sql = trim($_POST['sql'] ?? '');

    if (!hash_equals($_SESSION['sql_csrf_token'], $token)) {
        $mensagem = 'A sessão expirou. Recarregue a página e tente novamente.';
        $tipoMensagem = 'danger';
    } elseif ($sql === '') {
        $mensagem = 'Cole um comando SQL antes de executar.';
        $tipoMensagem = 'warning';
    } elseif (!isset($_POST['confirmar_execucao'])) {
        $mensagem = 'Confirme que deseja executar o SQL informado.';
        $tipoMensagem = 'warning';
    } else {
        require_once __DIR__ . '/../conexao.php';

        try {
            $quantidade = $pdo->exec($sql);
            $mensagem = 'SQL executado com sucesso. Registros afetados: ' . ($quantidade === false ? 0 : $quantidade) . '.';
            $tipoMensagem = 'success';
        } catch (PDOException $exception) {
            error_log('Falha ao executar SQL administrativo: ' . $exception->getMessage());
            $mensagem = 'Não foi possível executar o SQL: ' . $exception->getMessage();
            $tipoMensagem = 'danger';
        }
    }
}

require_once __DIR__ . '/../admin/includes/head.php';
?>

<link href="<?= site_path() ?>/admin/css/admin.css" rel="stylesheet">
<style>
    .sql-page {
        min-height: 100vh;
        padding: 3rem 0;
        background: #111;
    }

    .sql-card {
        padding: 2rem;
        background: #000;
        border: 2px solid #bb9000;
        border-radius: 15px;
    }

    .sql-card textarea {
        min-height: 420px;
        font-family: Consolas, "Courier New", monospace;
        font-size: .9rem;
        line-height: 1.5;
        resize: vertical;
    }

    .sql-alerta {
        color: #f2d68c;
        border-left: 4px solid #bb9000;
        padding-left: 1rem;
    }
</style>

<main class="sql-page">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <h1 class="titulo-admin m-0">Atualizar banco de dados</h1>
            <a href="<?= site_path() ?>/admin/" class="btn btn-voltar">Voltar ao painel</a>
        </div>

        <div class="sql-card">
            <p class="sql-alerta">
                Esta ferramenta executa o SQL diretamente no banco conectado. Use somente comandos revisados e faça um backup antes de operações destrutivas.
            </p>

            <?php if ($mensagem): ?>
                <div class="alert alert-<?= htmlspecialchars($tipoMensagem, ENT_QUOTES, 'UTF-8') ?>">
                    <?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= site_path() ?>/sql/">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['sql_csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

                <label for="sql" class="form-label">SQL para executar</label>
                <textarea id="sql" name="sql" class="form-control" required spellcheck="false" placeholder="Cole aqui o SQL que deseja executar..."><?= htmlspecialchars($_POST['sql'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" id="confirmar_execucao" name="confirmar_execucao" value="1" required>
                    <label class="form-check-label text-light" for="confirmar_execucao">
                        Confirmo que revisei o SQL e desejo executá-lo neste banco.
                    </label>
                </div>

                <button type="submit" class="btn btn-adicionar mt-4">
                    <i class="bi bi-database-gear"></i>
                    Executar SQL
                </button>
            </form>
        </div>
    </div>
</main>
