// Função que exibe o toast de maneira dinâmica
window.onload = function() {
    var toast = document.getElementById('toast');

    if (toast) {
        toast.style.display = 'block';
        // Aplica um fade-out no toast após 5 segundos
        setTimeout(function() {
            toast.style.opacity = 0;
            setTimeout(function() {
                toast.style.display = 'none';
                toast.style.opacity = 1; // Reset opacity for next use
            }, 500); // Tempo de animação de fade-out
        }, 5000);
    }
};

// Função de alternância do tema claro/escuro
document.getElementById('theme-toggle').addEventListener('click', function() {
    var body = document.body;
    var icon = document.getElementById('theme-icon');

    // Verifica se o tema já está no modo escuro ou claro
    if (body.classList.contains('light-mode')) {
        // Muda para o modo escuro
        body.classList.remove('light-mode');
        icon.classList.remove('fa-moon');
        icon.classList.add('fa-sun');
        document.documentElement.setAttribute('data-theme', 'dark');
    } else {
        // Muda para o modo claro
        body.classList.add('light-mode');
        icon.classList.remove('fa-sun');
        icon.classList.add('fa-moon');
        document.documentElement.setAttribute('data-theme', 'light');
    }
});
