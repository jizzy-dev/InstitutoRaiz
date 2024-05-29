function editarUsuarioInput(idUsuario) {
    window.location.href = '?pag=usuario&metodo=editar&id=' + idUsuario;
}
function editarAlunoInput(idAluno) {
    window.location.href = '?pag=aluno&metodo=editar&id=' + idAluno;
}
function atribuirPadrinhoInput(idPadrinho) {
    window.location.href = '?pag=padrinho&metodo=AtribuirPadrinho&id=' + idPadrinho;
}
function selectTurmaInputF() {
    const idTurma = document.getElementById('ID_TURMA').value;

    if (idTurma) {
        window.location.href = '?pag=frequencia&turma=' + idTurma;
    }
}
function selectTurmaInputMP() {
    const idTurma = document.getElementById('ID_TURMA').value;

    if (idTurma) {
        window.location.href = '?pag=frequencia&metodo=marcarPresenca&turma=' + idTurma;
    }
}