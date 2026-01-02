// tema/theme
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('theme-toggle');

    btn.addEventListener('click', () => {
        document.body.classList.toggle('light-theme');

        const theme = document.body.classList.contains('light-theme')
            ? 'light'
            : 'dark';

        document.cookie = `theme=${theme}; path=/; max-age=31536000`;
    });
});
// Inicialização do Grafico

function updateChartColors(isLight) {
    const gridColor = isLight ? '#e4e6eb' : '#2d2d3a';
    const textColor = isLight ? '#606770' : '#888';
    
    weeklyChart.options.scales.y.grid.color = gridColor;
    weeklyChart.options.scales.y.ticks.color = textColor;
    weeklyChart.options.scales.x.ticks.color = textColor;
    weeklyChart.update();
}

// Funções dos Modais
function abrirModal(id) {
    const modal = document.getElementById(id);
    modal.classList.add('active');
}

function fecharModal(id) {
    const modal = document.getElementById(id);
    modal.classList.remove('active');
}

// Fechar
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('active');
    }
};