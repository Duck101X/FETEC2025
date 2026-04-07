<h1>🎓 FETEC2025 - Sistema de Gestão de TCC</h1>
O FETEC2025 (StartTCC) é uma plataforma web desenvolvida para centralizar e organizar a interação entre orientadores e orientandos. O foco principal é otimizar o fluxo de envio, revisão e feedback de Trabalhos de Conclusão de Curso, eliminando a dispersão de arquivos em e-mails ou aplicativos de mensagem.

📖 Sobre o Projeto
O sistema oferece ambientes distintos e protegidos para que o processo de orientação seja transparente. Enquanto o aluno foca na evolução do texto e no cumprimento de prazos, o professor dispõe de ferramentas para baixar, analisar e registrar correções de forma centralizada.

<h2>🚀 Funcionalidades</h2>
👨‍🎓 Área do Aluno
Autenticação Segura: Login individual para acesso ao painel.

Gestão de Documentos: Upload de arquivos do TCC diretamente para o servidor.

Central de Feedback: Visualização em tempo real das correções e comentários feitos pelo orientador.

Timeline de Progresso: Acompanhamento do status atual do trabalho.

<h2>👨‍🏫 Área do Professor</h2>
Painel de Orientação: Visualização de todos os trabalhos enviados pelos alunos.

Análise de Arquivos: Download rápido dos documentos para revisão.

Sistema de Correção: Cadastro de comentários detalhados e salvamento de notas/status.

Gestão de Arquivos: Possibilidade de excluir ou atualizar registros conforme a evolução do projeto.

<h1>🛠️ Tecnologias Utilizadas</h1>
Front-end: HTML5, CSS3 e JavaScript (para interações na interface e validações).

Back-end: PHP (Lógica de servidor e gestão de sessões).

Banco de Dados: MySQL (Relacional).

Ambiente de Servidor: Compatível com XAMPP, WAMP ou Laragon.

📂 Estrutura de Pastas
```Plaintext
FETEC2025/
├── 📁 aluno/          # Dashboard, login e lógica de upload do aluno
├── 📁 professor/      # Dashboard, gestão de arquivos e comentários
├── 📁 banco de dados/ # Scripts SQL para criação das tabelas
├── 📁 img/            # Ativos visuais (Logos, fundos e ícones)
├── 📁 uploads/        # Diretório de armazenamento dos arquivos enviados
├── 📄 config.php      # Configuração centralizada da conexão com o BD
└── 📄 index.html      # Landing page / Porta de entrada do sistema
```
<h2>⚙️ Instalação e Configuração</h2>
Clonagem:

```
Bash
git clone https://github.com/Duck101X/FETEC2025.git
```
Banco de Dados:

Crie um banco de dados chamado starttcc no seu gerenciador (ex: phpMyAdmin).

Importe o arquivo .sql localizado na pasta /banco de dados/.

Conexão:

No arquivo config.php, ajuste as credenciais se necessário:
```
PHP
$host = "localhost";
$user = "root";
$password = "";
$database = "starttcc";
Diretório de Uploads:
```

Certifique-se de que as pastas uploads/ tenham permissões de escrita no seu servidor local.

<h2>🎯 Objetivo e Impacto</h2>
O projeto visa transformar a orientação acadêmica em um processo digital e rastreável, garantindo que nenhum feedback seja perdido e que o histórico de versões do TCC esteja sempre disponível para ambas as partes.

Desenvolvido por Duck101X 🚀
