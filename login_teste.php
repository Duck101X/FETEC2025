<?php
session_start();

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$tipo = $_POST['tipo'];

// Exemplo de logins fixos (simulação)
$logins = [
    "aluno" => ["usuario" => "aluno123", "senha" => "1234"],
    "professor" => ["usuario" => "prof123", "senha" => "abcd"]
];

if ($tipo && isset($logins[$tipo])) {
    if ($usuario === $logins[$tipo]["usuario"] && $senha === $logins[$tipo]["senha"]) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['tipo'] = $tipo;

        if ($tipo === "aluno") {
            header("Location: aluno.php");
            exit;
        } elseif ($tipo === "professor") {
            header("Location: professor.php");
            exit;
        }
    } else {
        echo "<script>alert('Usuário ou senha incorretos!'); window.location='index.html';</script>";
    }
} else {
    echo "<script>alert('Selecione o tipo de usuário!'); window.location='index.html';</script>";
}
?>