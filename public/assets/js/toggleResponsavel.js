function toggleResponsavel(id) {
    var row = document.getElementById('responsavel_' + id);
    if (row.style.display === 'none') {
        row.style.display = 'flex';
    } else {
        row.style.display = 'none';
    }
}