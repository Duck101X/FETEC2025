<?php
session_start();
include_once "../config.php";

// garante que id do aluno exista
if (!isset($_SESSION['idaluno']) && !isset($_SESSION['id'])) {
    header("Location: aluno_login.php");
    exit();
}

$idaluno = $_SESSION['idaluno'] ?? $_SESSION['id'];

// verifica se arquivo existe
if (!isset($_FILES['arquivo'])) {
    $_SESSION['erro'] = "Nenhum arquivo enviado.";
    header("Location: aluno.php");
    exit();
}

$arquivo = $_FILES['arquivo'];
$pasta = "../uploads/";

// cria pasta caso não exista
if (!is_dir($pasta)) {
    mkdir($pasta, 0777, true);
}

$nomeOriginal = $arquivo['name'];
$nomeFinal = uniqid() . "-" . $nomeOriginal;

$caminho = $pasta . $nomeFinal;
$caminhoBD = "uploads/" . $nomeFinal; // o que vai para o banco

// move arquivo
if (move_uploaded_file($arquivo['tmp_name'], $caminho)) {

    // insere NA TABELA ARQUIVOS
    $sql = "INSERT INTO arquivos (id_aluno, caminho, nome_original)
            VALUES ($idaluno, '$caminhoBD', '$nomeOriginal')";

    if ($conexao->query($sql)) {
        $_SESSION['sucesso'] = "Arquivo enviado com sucesso!";
        header("Location: aluno.php");
        exit();
    } else {
        $_SESSION['erro'] = "Erro ao salvar no banco: " . $conexao->error;
        header("Location: aluno.php");
        exit();
    }

} else {
    $_SESSION['erro'] = "Erro ao mover o arquivo!";
    header("Location: aluno.php");
    exit();
}
