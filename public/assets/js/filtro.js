function buscar() {
    var filtroSelecionado = document.getElementById('filtroSelect').value;
    var filtro = document.getElementById('filtro').value;
    console.log("Função buscar() chamada.");

    // Verificar valores de filtroSelect e filtro
    console.log("Valor de filtroSelect:", filtroSelect);
    console.log("Valor de filtro:", filtro);

    window.location.href = '?pag=usuario&metodo=consultar&filtro=' + filtroSelecionado + "&valor=" + filtro;
}