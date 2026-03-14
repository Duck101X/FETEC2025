<?php
include_once '../config.php';

// Verificar qual ação o usuário está fazendo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // --- 1. CRIAR CONTA DE ALUNO ---
    if (!empty($_POST['user']) && !empty($_POST['senha'])) {
        
        $user = $_POST['user'];
        $senha = $_POST['senha']; 
        // Lembre-se: Você DEVE usar password_hash() aqui para segurança real!

        // Prepara a query SQL para inserir nas colunas 'user' e 'senha'
        // A coluna 'idalunos' é AUTO INCREMENT e não precisa ser mencionada aqui.
        $sql = "INSERT INTO alunos(user, senha) VALUES (?, ?)";
        
        $stmt = $conexao->prepare($sql);
        
        // 'ss' significa que estamos passando dois parâmetros do tipo string
        $stmt->bind_param("ss", $user, $senha);

        // AQUI ESTÁ A LINHA QUE FALTAVA: Executar a query
        if ($stmt->execute()) {
            header("Location: professor.php");
            //echo "Conta criada com sucesso para: " . htmlspecialchars($user);
        } else {
            header("Location: professor.php=erro=1");
            echo "Erro ao criar conta.";
            // Se houver um erro na execução, mostre-o para depuração
            //echo "Erro ao salvar no banco de dados: " . $stmt->error;
        }
        
        // Fechar a declaração
        $stmt->close();
    }
    
    // --- 2. ENVIAR CORREÇÕES ---
    if (!empty($_POST['comentarios'])) {
        $comentarios = $_POST['comentarios'];
        // TODO: Salvar correções no banco de dados (adicione o código SQL aqui)
        echo "Correções enviadas!";
    }
}

// Fechar a conexão no final do script
if (isset($conexao)) {
    $conexao->close();
}
?>