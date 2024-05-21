function editarUsuario(idUsuario) {
    // Redirecionar o usuário para a página de edição com o ID do usuário como parte da URL
    window.location.href = '?pag=usuario&metodo=editar&id=' + idUsuario;
}
function editarAluno(idAluno) {
    // Redirecionar o usuário para a página de edição com o ID do usuário como parte da URL
    window.location.href = '?pag=aluno&metodo=editar&id=' + idAluno;
}