<?php
include_once "../config.php";
session_start();

if (!isset($_POST['comentario'], $_POST['id_aluno'], $_POST['id_arquivo'])) {
    die("Dados incompletos.");
}

$comentario = $conexao->real_escape_string($_POST['comentario']);
$idAluno = (int) $_POST['id_aluno'];
$idArquivo = (int) $_POST['id_arquivo'];

$sql = "
INSERT INTO comentarios (id_aluno, id_arquivo, comentario)
VALUES ($idAluno, $idArquivo, '$comentario')
";

if ($conexao->query($sql)) {
    header("Location: professor.php?msg=Comentario_enviado");
    exit;
} else {
    die("Erro ao salvar comentário: " . $conexao->error);
}
