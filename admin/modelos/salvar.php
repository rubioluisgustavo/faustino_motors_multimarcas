<?php

require_once "../../conexao.php";
require_once "../includes/auth.php";
require_once __DIR__ . '/ModeloRepository.php';


// Dados recebidos

$id = isset($_POST['id']) && $_POST['id'] !== '' ? (int) $_POST['id'] : null;
$idMarca = isset($_POST['id_marca']) && $_POST['id_marca'] !== '' ? (int) $_POST['id_marca'] : null;
$nome = trim($_POST['nome'] ?? '');

if ($idMarca === null || $nome === '') {
    header('Location: cadastro.php' . ($id ? '?id=' . $id : ''));
    exit;
}

(new ModeloRepository($pdo))->salvar(new Modelo($id, $idMarca, $nome));





// retorna para lista

header("Location: index.php");

exit;
