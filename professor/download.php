<?php
if (!isset($_GET['file'])) {
    die("Arquivo não especificado.");
}

// pega só o nome real
$arquivo = basename($_GET['file']);

// caminho REAL dos uploads do aluno
$caminho = "../uploads/" . $arquivo;

if (!file_exists($caminho)) {
    die("Arquivo não encontrado: " . $caminho);
}

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$arquivo\"");
header("Content-Length: " . filesize($caminho));

readfile($caminho);
exit;
?>
