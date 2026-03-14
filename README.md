# FETEC2025
FETEC2025 é uma plataforma web desenvolvida em PHP, HTML, CSS e JavaScript para facilitar a comunicação entre alunos e professores no processo de desenvolvimento de TCC. O sistema permite o envio, acompanhamento, correção e gerenciamento de trabalhos acadêmicos, oferecendo um ambiente organizado e prático para orientação e feedback dos projetos.

📚 FETEC2025

Plataforma web desenvolvida para facilitar a interação entre alunos e professores no processo de envio, acompanhamento e correção de Trabalhos de Conclusão de Curso (TCC).

O sistema permite que alunos enviem seus trabalhos, acompanhem feedbacks e recebam orientações, enquanto professores podem revisar arquivos, deixar comentários e orientar os estudantes durante o desenvolvimento do TCC.

🚀 Funcionalidades
👨‍🎓 Aluno

Login de aluno

Envio de arquivos de TCC

Visualização de correções e comentários

Acompanhamento do progresso do trabalho

👨‍🏫 Professor

Login de professor

Download dos TCCs enviados

Correção e comentários nos trabalhos

Gerenciamento dos arquivos recebidos

🌐 Sistema

Separação de acesso entre aluno e professor

Upload e download de arquivos

Interface web responsiva

Estrutura organizada em PHP, HTML, CSS e JavaScript

🛠️ Tecnologias Utilizadas

HTML5

CSS3

JavaScript

PHP

MySQL (estrutura de banco presente na pasta banco de dados)

Servidor local (XAMPP / WAMP / Laragon)

📂 Estrutura do Projeto
StartTCC/
│
├── aluno/
│   ├── uploads/
│   ├── aluno_login.php
│   ├── aluno.php
│   ├── sair.php
│   └── upload_tcc.php
│
├── professor/
│   ├── download.php
│   ├── excluir.php
│   ├── professor_login.php
│   ├── professor.php
│   ├── salvar.php
│   └── salvar_comentario.php
│
├── img/
│   ├── Fundo.png
│   ├── logo.png
│   ├── olho.png
│   └── olho-marcado.png
│
├── banco de dados/
│   └── (arquivos SQL do projeto)
│
├── uploads/
│
├── config.php
├── index.html
├── selection.html
├── script.js
└── login_teste.php

⚙️ Como Executar o Projeto

1️⃣ Clonar o repositório

git clone https://github.com/seu-usuario/starttcc.git

2️⃣ Colocar o projeto no servidor local

Coloque a pasta dentro do diretório do servidor.

Exemplo no XAMPP:

htdocs/starttcc
3️⃣ Configurar o banco de dados

Abra o phpMyAdmin

Crie um banco de dados

Importe o arquivo SQL presente na pasta:

banco de dados/
4️⃣ Configurar conexão

No arquivo:

config.php

Configure os dados de acesso ao banco:

$host = "localhost";
$user = "root";
$password = "";
$database = "starttcc";
5️⃣ Executar o projeto

Abra no navegador:

http://localhost/starttcc
🎯 Objetivo do Projeto

O StartTCC foi desenvolvido como uma solução para melhorar a comunicação entre alunos e professores durante o processo de orientação de TCCs, centralizando envio de arquivos, correções e acompanhamento em uma única plataforma.

📸 Interface

O sistema possui:

Página inicial com apresentação da plataforma

Tela de seleção de login (Aluno / Professor)

Área de envio de TCC para alunos

Área de correção e gerenciamento para professores
