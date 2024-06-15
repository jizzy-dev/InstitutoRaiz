function buscarNomeAluno(alunoObject) {
    var idAlunoInput = document.getElementById("id_aluno");
    var nomeAlunoInput = document.getElementById("nome_aluno");
    const main = document.querySelector('main')

    const alunos = alunoObject
    for (const idAluno in alunos) {
        const aluno = alunos[idAluno];

        main.innerHTML += `${aluno.nome}`
    }
    console.log(alunoObject);
}

