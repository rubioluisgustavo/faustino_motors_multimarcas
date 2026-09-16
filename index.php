<!doctype html>
<html lang="pt">

<head>
    <?php require_once __DIR__ . '/includes/head.php'; ?>
    <?php require_once __DIR__ . '/includes/assets.php'; ?>
    <link href="<?= site_path() ?>/styles.css?v=4" rel="stylesheet">
</head>

<body>
    <?php include('navbar.php'); ?>
    <?php include('menu.php'); ?>
    <?php if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {

        include("veiculo.php");
    } else if (isset($_GET['menu'])) {
        switch ($_GET['menu']) {
            case 'empresa':
                include("empresa.php");
                break;
            case 'vendidos':
                include("vendidos.php");
                break;
            case 'financiamento':
                include("financiamento.php");
                break;
            case 'pre-simulacao':
                include("pre-simulacao.php");
                break;
            case 'contato':
                include("contato.php");
                break;

            default:
                # code...
                break;
        }
    } else {
        include("filter.php");
        include("veiculos.php");
    }?>
    <?php include("footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>