document.addEventListener("DOMContentLoaded", function() {
    var idAlunoInput = document.getElementById("id_aluno");
    var nomeAlunoInput = document.getElementById("nome_aluno");

    idAlunoInput.addEventListener("blur", function() {
        var idAluno = idAlunoInput.value;

        // Faz uma solicitação AJAX para buscar os detalhes do aluno com base no ID fornecido
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "?pag=padrinho&metodo=buscarNomeAluno", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Atualiza o objeto aluno com os detalhes do aluno retornado pela solicitação AJAX
                    window.aluno = response.aluno;
                    // Atualiza o valor do campo nome do aluno com o nome retornado pela solicitação AJAX
                    nomeAlunoInput.value = response.aluno.nome;
                } else {
                    // Se a solicitação falhar ou o aluno não for encontrado, limpa o objeto aluno e o campo de nome do aluno
                    window.aluno = {};
                    nomeAlunoInput.value = "";
                }
            }
        };
        xhr.send("id_aluno=" + idAluno);
    });
});
