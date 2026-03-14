<?php
session_start();

// 1. LÓGICA DE PROCESSAMENTO (SÓ RODA APÓS SUBMISSÃO DO FORMULÁRIO)
if(isset($_POST['entrar']) && !empty($_POST['user']) && !empty($_POST['senha'])) 
{
    include_once('../config.php'); 

    $user  = $conexao->real_escape_string($_POST['user']);
    $senha = $conexao->real_escape_string($_POST['senha']);

    $sql = "SELECT * FROM alunos WHERE user = '$user' AND senha = '$senha'";
    $result = $conexao->query($sql);

    if($result->num_rows < 1)
    {
        $_SESSION['erro_login'] = "Usuário ou senha incorretos.";
        unset($_SESSION['user'], $_SESSION['senha']);

        header('Location: aluno_login.php');
        exit();
    } 
    else 
    {
        $usuario = $result->fetch_assoc();
        $_SESSION['idaluno'] = $usuario['idalunos'];
        $_SESSION['user'] = $user;
        $_SESSION['senha'] = $senha;

        header('Location: aluno.php');
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auxílio TCC - Login Professor</title>
    <link rel="stylesheet" href="aluno_login.css"> 
</head>
<body>
    <div class="center-screen">
    <div id="loginForm" class="center fade-in">
        <h2>Login - Aluno</h2>

        <?php if (isset($_SESSION['erro_login'])): ?>
            <p style="color: red; margin-bottom: 15px;"><?php echo $_SESSION['erro_login']; ?></p>
            <?php unset($_SESSION['erro_login']); // Limpa a mensagem após exibir ?>
        <?php endif; ?>

        <form action="aluno_login.php" method="POST">
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