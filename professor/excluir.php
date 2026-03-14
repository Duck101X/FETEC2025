<?php
include_once '../config.php';

// Verifica se o ID do aluno foi fornecido
if (!empty($_GET['idalunos'])) {
    // força inteiro para garantir segurança básica
    $idalunos = (int) $_GET['idalunos'];

    // 1. DELETAR COMENTÁRIOS ASSOCIADOS AOS ARQUIVOS DESSE ALUNO
    // Primeiro, encontramos os IDs dos arquivos que o aluno enviou.
    $sqlSelectArquivos = "SELECT id FROM arquivos WHERE id_aluno = $idalunos";
    $resultArquivos = $conexao->query($sqlSelectArquivos);

    if ($resultArquivos && $resultArquivos->num_rows > 0) {
        $arquivo_ids = [];
        while ($row = $resultArquivos->fetch_assoc()) {
            $arquivo_ids[] = $row['id'];
        }
        
        // Converte o array de IDs em uma string para usar na cláusula IN
        $ids_string = implode(',', $arquivo_ids);

        // Deleta todos os comentários relacionados a esses arquivos
        if (!empty($ids_string)) {
            $sqlDeleteComentarios = "DELETE FROM comentarios WHERE id_arquivo IN ($ids_string)";
            // Executamos a query. Não precisamos de confirmação estrita, pois pode não haver comentários.
            $conexao->query($sqlDeleteComentarios);
        }
    }
    
    // 2. DELETAR ARQUIVOS (TCCs) ENVIADOS PELO ALUNO
    // A deleção dos arquivos é necessária antes de deletar o aluno (Foreign Key)
    $sqlDeleteArquivos = "DELETE FROM arquivos WHERE id_aluno = $idalunos";
    $resultDeleteArquivos = $conexao->query($sqlDeleteArquivos);

    // 3. DELETAR O ALUNO
    // Se a deleção dos arquivos foi bem-sucedida (ou se não havia arquivos)
    if ($resultDeleteArquivos !== false) { 
        $sqlDeleteAluno = "DELETE FROM alunos WHERE idalunos = $idalunos";
        $resultDeleteAluno = $conexao->query($sqlDeleteAluno);

        if ($resultDeleteAluno) {
            // Sucesso! Redireciona com mensagem
            header("Location: professor.php?msg=OK_DELETE");
            exit();
        } else {
            echo "Erro ao excluir aluno: " . $conexao->error;
            exit();
        }
    } else {
        echo "Erro ao excluir arquivos relacionados: " . $conexao->error;
        exit();
    }
} else {
    // Redireciona se o ID do aluno não foi fornecido
    header("Location: professor.php");
    exit();
}