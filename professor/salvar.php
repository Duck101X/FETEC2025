<?php
include_once "../config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['acao'] === 'editar') {

        $id = intval($_POST['idalunos']);
        $user = $conexao->real_escape_string($_POST['user']);
        $senha = $conexao->real_escape_string($_POST['senha']);

        $sql = "UPDATE alunos SET user='$user', senha='$senha' WHERE idalunos=$id";

        if ($conexao->query($sql)) {
            echo "OK_EDIT";  // <-- ESSA LINHA É OBRIGATÓRIA
        } else {
            echo "ERRO_EDIT";
        }

        exit();
    }
}
?>
