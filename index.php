<?php

error_reporting(E_ERROR);
ini_set('display_errors', 1);

require_once __DIR__ . '/app/bootstrap.php';

$siteController = new App\Controllers\SiteController($pdo);
$pagina = $_GET['menu'] ?? null;
$idVeiculo = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$conteudo = 'site/estoque';
$dadosConteudo = [];
$dadosFiltro = [];
$exibirFiltro = false;

if ($idVeiculo) {
    $detalhes = $siteController->detalhes($idVeiculo);

    if ($detalhes === null) {
        redirect('');
    }

    $conteudo = 'site/detalhe';
    $dadosConteudo = $detalhes;
} elseif ($pagina === 'empresa') {
    $conteudo = 'site/empresa';
} else {
    $conteudo = 'site/estoque';
    $dadosConteudo = $siteController->estoque($_GET);
    $dadosFiltro = $siteController->filtros();
    $exibirFiltro = true;
}
?>

<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= asset('public/img/favicon-16x16.png') ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <title>Faustino Motors Multimarcas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="<?= asset('styles.css?v=4') ?>" rel="stylesheet">
</head>

<body>
    <?php view('components/navbar'); ?>
    <?php view('components/menu'); ?>

    <?php if ($exibirFiltro): ?>
        <?php view('site/filtro', $dadosFiltro); ?>
    <?php endif; ?>

    <?php view($conteudo, $dadosConteudo); ?>

    <?php view('components/footer'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>
