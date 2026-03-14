<?php
session_start();

// 1. LÓGICA DE PROCESSAMENTO (SÓ RODA APÓS SUBMISSÃO DO FORMULÁRIO)
if(isset($_POST['entrar']) && !empty($_POST['user']) && !empty($_POST['senha'])) 
{
    // O 'config.php' está na pasta PAI (../), então ajustamos o caminho:
    include_once('../config.php'); 

    // --- VARIÁVEIS DO FORMULÁRIO ---
    $userDigitado = $_POST['user'];
    $senhaDigitada = $_POST['senha'];

    // --- LOGIN PADRÃO (HARDCODED) ---
    $defaultUser = "admin";
    $defaultPass = "1234";

    if ($userDigitado === $defaultUser && $senhaDigitada === $defaultPass) {
        $_SESSION['user'] = $defaultUser;
        $_SESSION['senha'] = $defaultPass;
        $_SESSION['idprofessor'] = 1; // ID padrão para o admin
        header("Location: professor.php");
        exit();
    }
    
    // **BOA PRÁTICA: Usar mysqli_real_escape_string para evitar SQL Injection**
    $user = $conexao->real_escape_string($userDigitado);
    $senha = $conexao->real_escape_string($senhaDigitada);
    
    // Consulta SQL
    // Se a coluna na tabela professor for 'id', o SELECT deve incluir ela.
    // Assumimos que a tabela professor tem as colunas 'idprofessor', 'user' e 'senha'.
    $sql = "SELECT * FROM professor WHERE user = '$user' AND senha = '$senha'";
    $result = $conexao->query($sql);

    // --- LÓGICA DE VERIFICAÇÃO DE LOGIN NO BANCO DE DADOS ---
    if($result->num_rows < 1)
    {
        // ❌ FALHA no login (Não é admin e não está no banco)
        $_SESSION['erro_login'] = "Usuário ou senha incorretos.";
        unset($_SESSION['user']);
        unset($_SESSION['senha']);
        
        // Redireciona para a própria página de login
        header('Location: professor_login.php'); 
        exit(); 
    } else {
        // ✅ SUCESSO no login
        $usuario = $result->fetch_assoc(); 
        
        // *** CORREÇÃO APLICADA AQUI: USAR 'idprofessor' ou 'id' ***
        // Assumindo que a coluna chave primária na tabela 'professor' é 'idprofessor'
        $_SESSION['idprofessor'] = $usuario['idprofessor'] ?? $usuario['id'] ?? null; 
        
        $_SESSION['user'] = $user;
        $_SESSION['senha'] = $senha;

        // Limpa qualquer mensagem de erro antiga
        if (isset($_SESSION['erro_login'])) {
            unset($_SESSION['erro_login']);
        }

        header('Location: professor.php'); 
        exit(); 
    }
}

// 2. EXIBIÇÃO DA PÁGINA
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auxílio TCC - Login Professor</title>
    <link rel="stylesheet" href="professor_login.css"> 
</head>
<body>
    <div class="center-screen">
    <div id="loginForm" class="center fade-in">
        <h2>Login - Professor</h2>

        <?php if (isset($_SESSION['erro_login'])): ?>
            <p style="color: red; margin-bottom: 15px;"><?php echo $_SESSION['erro_login']; ?></p>
            <?php unset($_SESSION['erro_login']); // Limpa a mensagem após exibir ?>
        <?php endif; ?>

        <form action="professor_login.php" method="POST">
            <input class="input" type="text" name="user" placeholder="Usuário" required>
            <div class="input-group"> 
            <input type="password" id="senha" name="senha" placeholder="Senha" required>   
            <button type="button" onclick="mostrarSenha()" class="toggle-password">
                <img id="icone-olho" src="../img/olho.png" alt="Mostrar senha">
            </button>
        </div>
            <button class="btn" type="submit" name="entrar">Entrar</button>
        </form>
        
        <button class="btn-secondary" onclick="window.location.href='../selection.html'">Voltar</button>
    </div>
    </div>

      <script>
    function mostrarSenha() {
      var senha = document.getElementById("senha");
      var icone = document.getElementById("icone-olho");
      if (senha.type === "password") {
        senha.type = "text";
        icone.src = "../img/olho-marcado.png";
      } else {
        senha.type = "password";
        icone.src = "../img/olho.png";
      }
    }
  </script>
    </body>
</html>