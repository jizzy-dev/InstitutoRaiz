function redirecionarPorId(idUsuario) {
    // Redirecionar o usuário para a página de edição com o ID do usuário como parte da URL
    window.location.href = '?pag=usuario&id=' + idUsuario;
}