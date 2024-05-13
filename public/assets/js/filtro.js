function buscar() {
    var filtro = document.getElementById('filtro').value;
    window.location.href = '?pag=usuario&metodo=consultar&nome=' + filtro;
}