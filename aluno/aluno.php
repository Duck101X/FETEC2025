<?php
session_start();

// Verifica sessão
if (!isset($_SESSION['user']) || !isset($_SESSION['senha'])) {
    header('Location: aluno_login.php');
    exit();
}

// pega id do aluno
$idaluno = $_SESSION['idaluno'] ?? $_SESSION['id'] ?? null;
if (!$idaluno) {
    header('Location: aluno_login.php');
    exit();
}

include_once "../config.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Área do Aluno</title>
<link rel="stylesheet" href="aluno.css">

<style>
.hidden { display: none; }
</style>

</head>
<body>

<button class="menu-mobile-toggle" onclick="toggleSidebar()">☰</button>

<div class="sidebar" id="sidebar"> 
    
    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>

    <button type="button" onclick="showPage('enviarTcc')">Enviar TCC</button>
    <button type="button" onclick="showPage('correcoes')">Correções</button>
    <button type="button" onclick="showPage('dicas')">Dicas e Modelos</button>
    <a href="sair.php"><button type="button">Sair</button></a>
</div>

<div class="content">

<div id="enviarTcc" class="fade-in">
    <h2>Upload de TCC 📤</h2>

    <div class="upload-box">
        <p class="upload-info">Selecione o arquivo do seu TCC para enviar. Apenas documentos (PDF/DOCX) são aceitos.</p>
        
        <form action="upload_tcc.php" method="POST" enctype="multipart/form-data" class="upload-form">
            
            <input class="input-file-custom" type="file" name="arquivo" id="file-upload" required>
            <label for="file-upload" class="btn-file-label">
                Escolher Arquivo...
            </label>
            
            <button class="btn btn-upload" type="submit">Enviar Arquivo</button>
        </form>

        <?php
        // Mensagens de feedback
        if (isset($_SESSION['sucesso'])) {
            echo "<p class='msg-sucesso'>✅ " . htmlspecialchars($_SESSION['sucesso']) . "</p>";
            unset($_SESSION['sucesso']);
        }
        if (isset($_SESSION['erro'])) {
            echo "<p class='msg-erro'>❌ " . htmlspecialchars($_SESSION['erro']) . "</p>";
            unset($_SESSION['erro']);
        }
        ?>
    </div>
    
    <h3>Histórico de Arquivos Enviados:</h3>

    <div class="arquivo-feed">
    <?php
    $sql = "SELECT * FROM arquivos WHERE id_aluno = $idaluno ORDER BY data_envio DESC";
    $result = $conexao->query($sql);
    
    // DEFINA AQUI O CAMINHO CORRETO PARA A PASTA DE UPLOADS, 
    // relativo ao arquivo 'aluno.php'
    // Exemplo: Se 'aluno.php' está em 'aluno/' e uploads em 'uploads/tcc_files/', use:
    $upload_dir = '../uploads/tcc_files/'; 

if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $nome = htmlspecialchars($row['nome_original']);
            
            // O caminho no DB (sem o prefixo de pasta) é o que 'download.php' precisa
            $caminho_db = htmlspecialchars($row['caminho']); 
            
            $data = date('d/m/Y H:i', strtotime($row['data_envio']));
            
            // CARD (item do feed) - O nome do arquivo agora faz o DOWNLOAD
            echo "<div class='tcc-item fade-in'>
                      <div class='item-meta'>
                          <span class='item-nome'>📄 <a href='../professor/download.php?file=" . urlencode($caminho_db) . "'>" . $nome . "</a></span>
                          <span class='item-data'>Enviado em: " . $data . "</span>
                      </div>
                  </div>";
        }
    } else {
        echo "<p>Nenhum arquivo enviado ainda. Comece enviando seu TCC!</p>";
    }
    ?>
    </div>
</div>
<div id="correcoes" class="hidden">
    <h2>Correções do Professor 💬</h2>

    <?php
    $sqlC = "
        SELECT c.comentario, c.data_envio, a.nome_original
        FROM comentarios c
        JOIN arquivos a ON a.id = c.id_arquivo
        WHERE c.id_aluno = $idaluno
        ORDER BY c.data_envio DESC
    ";

    $resC = $conexao->query($sqlC);

    if ($resC->num_rows > 0) {
        while ($c = $resC->fetch_assoc()) {
            // Estrutura do card de correção
            echo "<div class='correcao-box fade-in'> 
                      <div class='correcao-meta'>
                          <span class='meta-arquivo'>
                              📂 Arquivo: " . htmlspecialchars($c['nome_original']) . "
                          </span>
                          <span class='meta-data'>
                              Enviada em: " . date('d/m/Y H:i', strtotime($c['data_envio'])) . "
                          </span>
                      </div>
                      
                      <div class='correcao-msg'>
                          <strong>Comentário do Professor:</strong>
                          <br>
                          " . nl2br(htmlspecialchars($c['comentario'])) . "
                      </div>
                  </div>";
            
            // Remove a <hr> anterior, o box já tem espaçamento
        }
    } else {
        echo "<p>🎉 Nenhuma correção enviada ainda. Seu TCC está indo bem!</p>";
    }
    ?>
</div>

<div id="dicas" class="hidden">

    <section class="secao-principal">
        <div class="sobreposicao-hero">
            <h1 class="titulo-site">Dicas e Modelos</h1>
            <div class="conteudo-principal">
                <p class="descricao-principal">Bem vindo</p>
            </div>
        </div>
    </section>

    <section class="secao-conteudo secao-tcc">
        <div class="container-conteudo">
            <div class="bloco-texto">
                <h2>O que é TCC?</h2>
                <p>O TCC, sigla para Trabalho de Conclusão de Curso, é uma atividade de investigação científica no
meio educacional brasileiro que acontece no final de uma graduação, finalizando a trajetória
acadêmica do aluno.</p>
            </div>
            <div class="bloco-imagem imagem-tcc"></div>
        </div>
    </section>

    <section class="secao-conteudo secao-estagio">
        <div class="container-conteudo layout-invertido">
            <div class="bloco-imagem imagem-estagio"></div>
            <div class="bloco-texto">
                <h2>O que é Estágio?</h2>
                <p>É um período de atividade práticas supervisionadas realizadas no horário oposto 
as atividades escolares em uma empresa onde ao final se deve entregar um 
relatório, que faz parte do processo de formação do aluno no ensino médio, 
substituindo o TCC.</p>
            </div>
        </div>
    </section>

    <section class="secao-conteudo secao-dica">
        <div class="container-conteudo">
            <div class="bloco-texto">

                <h2>Como consigo uma vaga de estágio?</h2> 	
                <br> 	 	
                <p>Fale seu com professor responsável pelos estágios, ou se preferir, de vagas de 
empresas.</p> <br> <br>
                <h2>Requisitos para começar o estágio:</h2> 	 	
                <br> 	
                <p>Estar matriculado e cursando o ensino médio, ter idade mínima de 16 anos, ter 
Seguro contra acidentes e o termo de compromisso assinado.</p>

<br><br>
                <h2>Quanto tempo dura?</h2> 	
                <br> 	 	
                <p>140 horas, somente 4 horas por dia (20 semanais) para alunos que ainda estão 
estudando e 6 horas (30 semanais) para alunos egressos.</p>
<br><br>
                <h2>Como consigo o seguro?</h2> 		 
<br>
                <p>O seguro é fornecido pelo estado de forma gratuita devendo apenas ser solicitado 
pelo aluno, que se desejar, também pode pagar pelo serviço.</p>
<br><br>
                <h2>O que é um relatório de Conclusão de Estágio?</h2>
                <br>
                <p>O Relatório de Conclusão de Estágio é um documento obrigatório para a 
finalização oficial do estágio supervisionado. Por meio dele, são registradas as 
atividades desenvolvidas, os conhecimentos adquiridos e as experiências 
vivenciadas durante o período de estágio. Este documento tem como objetivo 
apresentar o funcionamento do estágio, suas etapas e a contribuição dessa 
vivência para a formação técnica do estudante.</p>
<br><br>
                	<h2>Como é avaliado?</h2>
                	<br>
                	<p>Pela observação direta e entrega do relatório de conclusão de estágio
-A observação direta avalia o cumprimento de atividades, qualidade
do trabalho, frequência, pontualidade, comportamento, habilidades 
técnicas, conhecimentos adquiridos, potencial, dedicação e o 
relatório.
- O relatório avalia sua estrutura, organização, gramática, clareza, 
conteúdo técnico e sua relevância, capacidade de reflexão do 
estagiário e cumprimento das orientações e formatação solicitadas 
pela escola.
*Observação: O Relatório deve seguir o formato das normas ABNT 
atualizadas e ser encadernado.</p>
<br><br>

                <section>
                    <h2>Baixe os arquivos do estágio</h2>   

                    <a href="./uploads/PlanodeEstagio _Supervisor.docx" download>
                        <button><span class="button_top">Plano de estágio.</span></button>
                    </a>

                    <a href="./uploads/Orientações para relatório de estágio.docx" download>
                        <button><span class="button_top">Orientações para relatório.</span></button>
                    </a>

                    <a href="./uploads/O QUE É TCC E SUA IMPORTÂNCIA NO ENSINO TÉCNICO.pdf" download>
                        <button><span class="button_top">O que é TCC e sua importância no ensino técnico.</span></button>
                    </a>

                    <a href="./uploads/Frequência diária - Estagiário.docx" download>
                        <button><span class="button_top">Frequência diária.</span></button>
                    </a>

                    <a href="./uploads/Fichadedados-EstágioSupervisionado.docx" download>
                        <button><span class="button_top">Informações necessárias para preenchimento do termo de compromisso.</span></button>
                    </a>

                    <a href="./uploads/Ficha de desempenho -  Supervisor.docx" download>
                        <button><span class="button_top">Ficha de desempenho</span></button>
                    </a>
                </section>
                </div>
        </div>
    </section>

    <h2> Vídeos de orientação de estagio e TCC</h2>
    <section class="secao-card-video">
      <div class="container-card-video">
        <div class="card">
          <div class="card-info">
            <iframe class="video-card"
                    width="100%" height="100%"
                    src="https://www.youtube.com/embed/zyit15PDW_Q"
                    title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
            </iframe>
          </div>
        </div>
      </div>
    </section>
    <section class="secao-card-video">
      <div class="container-card-video">
        <div class="card">
          <div class="card-info">
            <iframe class="video-card"
                    src="https://www.youtube.com/embed/j79FFHWamAM"
                    title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
            </iframe>
          </div>
        </div>
      </div>
    </section>
    </div> </div> <script>
// Função para mostrar/esconder as páginas (seu código original)
function showPage(id) {
    const pages = ['enviarTcc', 'correcoes', 'dicas'];
    pages.forEach(p => {
        const el = document.getElementById(p);
        if (el) el.classList.toggle('hidden', p !== id);
    });
}

// NOVO: Função para retrair/expandir a barra lateral (Desktop) e Abrir/Fechar no Mobile
function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    
    // No Desktop, alterna a classe 'collapsed' (retrátil)
    if (window.innerWidth > 768) {
        sidebar.classList.toggle("collapsed");
    } 
    // No Mobile, alterna a classe 'open' (mostra o menu escondido)
    else {
        sidebar.classList.toggle("open");
    }
}

// Inicialização: abrir aba via ?page=
(function(){
    const p = new URLSearchParams(location.search).get('page');
    if (p && document.getElementById(p)) showPage(p);
    else showPage('enviarTcc');
})();
</script>

<script src="../script.js"></script>

</body>
</html>