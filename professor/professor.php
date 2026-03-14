<?php
session_start();

// Verifica sessão
if (!isset($_SESSION['user']) || !isset($_SESSION['senha'])) {
    header('Location: professor_login.php');
    exit();
}

$idaluno = $_SESSION['idprofessor'] ?? $_SESSION['id'] ?? null;
if (!$idaluno) {
    header('Location: professor_login.php');
    exit();
}

include_once "../config.php";
?>

<?php
// BUSCAR TCCs
$sqlTcc = "
    SELECT 
        arq.*, 
        a.user AS aluno
    FROM arquivos arq
    JOIN alunos a ON a.idalunos = arq.id_aluno
    ORDER BY arq.data_envio DESC
";

$resultTcc = $conexao->query($sqlTcc);
if ($resultTcc === false) {
    die('Erro ao carregar TCCs: ' . $conexao->error);
}

// BUSCAR ALUNOS
$sqlList = "SELECT * FROM alunos";
$resultList = $conexao->query($sqlList);
if ($resultList === false) {
    die("Erro na consulta: " . $conexao->error);
}

$idalunos = "";
$user = "";
$senha = "";

if (!empty($_GET['idalunos'])) {
    $idalunos = (int) $_GET['idalunos'];
    $sqlSelect = "SELECT * FROM alunos WHERE idalunos = $idalunos";
    $result = $conexao->query($sqlSelect);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user = $row['user'];
        $senha = $row['senha'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Área do Professor</title>
<link rel="stylesheet" href="professor.css">

<style>
.msgBox {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #4CAF50;
    color: white;
    padding: 12px 18px;
    border-radius: 6px;
    font-size: 16px;
    display: none;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
    animation: fadeIn .3s ease;
}
.msgBox.error {
    background: #e53935;
}
@keyframes fadeIn {
    from {opacity: 0; transform: translateY(10px);}
    to {opacity: 1; transform: translateY(0);}
}
.hidden { display: none; }
</style>

</head>
<body>

<button class="menu-mobile-toggle" onclick="toggleSidebar()">☰</button>

<div class="sidebar" id="sidebar"> 
    
    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>

    <button type="button" onclick="showPageProf('criarContas')">Criar Contas</button>
    <button type="button" onclick="showPageProf('receberTcc')">Receber TCC</button>
    <button type="button" onclick="showPageProf('editar')">Editar</button>
    <a href="../aluno/sair.php"><button type="button">Sair</button></a>  
</div>

<div id="msgBox" class="msgBox">Mensagem</div>

<div class="content">

    <form action="proffunc.php" method="POST">
       <div class="fade-in" id="criarContas">
           <h2 style="text-align: center;">Criar Conta de Aluno 🧑‍🎓</h2>
           
           <div class="edit-box form-create">
               <input type="text" class="input" placeholder="Usuário" name="user" required>
               <input type="text" class="input" placeholder="Senha" name="senha" required>

               <button type="submit" class="btn">Criar Conta</button>
           </div>
       </div>
    </form>


    <div class="fade-in hidden" id="receberTcc">
        <h2>TCCs para Revisão 📑</h2>

        <div class="tcc-feed">

            <?php if ($resultTcc->num_rows > 0): ?>
                <?php while($tcc = $resultTcc->fetch_assoc()): ?>
                    
                    <div class="review-card fade-in">
                        
                        <div class="card-header">
                            <span class="header-aluno">
                                🎓 <strong>Aluno:</strong> <?= htmlspecialchars($tcc['aluno']) ?>
                            </span>
                            <span class="header-data">
                                Enviado em: <?= date('d/m/Y H:i', strtotime($tcc['data_envio'])) ?>
                            </span>
                        </div>

                        <div class="card-file-info">
                            <strong>Arquivo:</strong> 
                            <span class="file-name">
                                <a href="download.php?file=<?= urlencode($tcc['caminho']) ?>">
                                    💾 <?= htmlspecialchars($tcc['nome_original']) ?> (Baixar)
                                </a>
                            </span>
                        </div>
                        
                        <form action="salvar_comentario.php" method="POST" class="ajax-form coment-box">
                            <input type="hidden" name="id_aluno" value="<?= $tcc['id_aluno'] ?>">
                            <input type="hidden" name="id_arquivo" value="<?= $tcc['id'] ?>">

                            <textarea name="comentario" rows="3" placeholder="Escreva uma correção ou feedback para o aluno..." required></textarea>
                            <button type="submit" class="btn btn-small">Enviar Comentário</button>
                        </form>
                        
                        <?php
                            $idArq = $tcc['id'];
                            $sqlCom = "SELECT comentario, data_envio FROM comentarios 
                                       WHERE id_arquivo = $idArq 
                                       ORDER BY data_envio DESC";
                            $resCom = $conexao->query($sqlCom);
                            if ($resCom && $resCom->num_rows > 0):
                        ?>
                            <div class="comentarios-historico">
                                <strong class="history-title">Comentários enviados:</strong>

                                <?php while($c = $resCom->fetch_assoc()): ?>
                                    <div class="comentario-item">
                                        <small class="comment-data"><?= date('d/m/Y H:i', strtotime($c['data_envio'])) ?></small>
                                        <p class="comment-text"><?= nl2br(htmlspecialchars($c['comentario'])) ?></p>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                        
                    </div> <?php endwhile; ?>
            <?php else: ?>
                <p>🎉 Nenhum TCC enviado ainda.</p>
            <?php endif; ?>

        </div>
    </div>


    <div id="editar" class="hidden">
        <h2>Editar Alunos 📝</h2>

        <div class="edit-grid"> <?php while($row = $resultList->fetch_assoc()): ?>
            <form action="salvar.php" method="POST" class="ajax-form edit-box">

                <input type="hidden" name="acao" value="editar">
                <input type="hidden" name="idalunos" value="<?= $row['idalunos'] ?>">

                <label>Usuário:</label>
                <input type="text" name="user" value="<?= htmlspecialchars($row['user']) ?>">

                <label>Senha:</label>
                <input type="text" name="senha" value="<?= htmlspecialchars($row['senha']) ?>">

                <button type="submit" class="btn btn-edit-aluno">Salvar</button>

                <a href="excluir.php?idalunos=<?= $row['idalunos'] ?>"
                   class="btn-delete btn-edit-aluno"
                   onclick="return confirm('Tem certeza que deseja excluir este aluno?');">
                    Excluir
                </a>

            </form>
        <?php endwhile; ?>
        </div>
    </div>

</div>


<script>
// Função para alternar o estado da Sidebar (usada no botão do desktop e no botão mobile)
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const isMobile = window.innerWidth <= 768;

    if (isMobile) {
        // Modo Mobile: Abre/fecha totalmente (transform: translateX)
        sidebar.classList.toggle('open');
    } else {
        // Modo Desktop: Alterna entre expandido e recolhido (classes collapsed)
        sidebar.classList.toggle('collapsed');
    }
}

function showPageProf(page) {
    const pages = ['criarContas', 'receberTcc', 'editar'];
    pages.forEach(p => {
        const el = document.getElementById(p);
        if (el) el.style.display = 'none';
    });
    const target = document.getElementById(page);
    if (target) target.style.display = 'block';
}

document.addEventListener('DOMContentLoaded', () => {
    // Esconde a sidebar no mobile por padrão
    if (window.innerWidth <= 768) {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.remove('open'); 
        sidebar.classList.remove('collapsed');
    }
    
    showPageProf('criarContas');
});
</script>


<script>
// SISTEMA AJAX + ALERTA
document.addEventListener("DOMContentLoaded", () => {

    function showMsg(texto, erro = false) {
        const box = document.getElementById("msgBox");
        box.textContent = texto;

        if (erro) box.classList.add("error");
        else box.classList.remove("error");

        box.style.display = "block";

        setTimeout(() => {
            box.style.display = "none";
        }, 3000);
    }

    document.querySelectorAll(".ajax-form").forEach(form => {

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: form.method,
                    body: formData
                });

                let resposta = await response.text();

                if (resposta.includes("OK_COMENTARIO")) {
                    showMsg("Comentário enviado!");
                }
                else if (resposta.includes("OK_EDIT")) {
                    showMsg("Edição salva!");
                }
                else {
                    showMsg("Operação concluída.");
                }

                if (form.classList.contains("coment-box")) {
                    form.reset();
                }

            } catch (err) {
                showMsg("Erro ao enviar.", true);
            }
        });
    });

});
</script>

</body>
</html>