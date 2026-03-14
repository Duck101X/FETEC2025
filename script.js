let currentRole = null;
function showLogin(role) {
currentRole = role;
document.getElementById('loginSelect').classList.add('hidden');
document.getElementById('loginForm').classList.remove('hidden');
document.getElementById('loginTitle').innerText = `Login - ${role}`;
}
function backToSelect() {
document.getElementById('loginForm').classList.add('hidden');
document.getElementById('loginSelect').classList.remove('hidden');
}
function login() {
if (currentRole === 'aluno') {
window.location.href = './aluno/aluno.php';
} else {
window.location.href = './professor/professor.php';
}
}
function showPageProf(page) {
    const pages = ['criarContas', 'receberTcc', 'editar'];
    pages.forEach(p => {
        const el = document.getElementById(p);
        if (el) {
            el.classList.add('hidden');
        }
    });
    const target = document.getElementById(page);
    if (target) {
        target.classList.remove('hidden');
    }
}

function showPage(page) {
    // IDs dos contêineres de conteúdo na página 'aluno.html'
    const pages = ['enviarTcc', 'correcoes', 'dicas']; 

    // Oculta todos os contêineres do aluno
    pages.forEach(p => {
        const el = document.getElementById(p);
        if (el) {
            el.classList.add('hidden');
        }
    });

    // Mostra o contêiner de destino
    const target = document.getElementById(page);
    if (target) {
        target.classList.remove('hidden');
    }
}