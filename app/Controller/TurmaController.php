<?php

class TurmaController {
    public function index() {
        global $parametros;

        // Seleciona alunos com situação de matrícula aprovada
        $alunos = Aluno::selecionarPorSituacao('aprovado');
        $turmas = Turma::selecionarTodas();

        $parametros = [
            'alunos' => $alunos,
            'turmas' => $turmas,
            'titulo' => 'Atribuir Aluno a Turma'
        ];
        echo TemplateRenderer::render('atribuir_turma.html', $parametros);
    }

    public function atribuirTurma() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idAluno = $_POST['id_aluno'];
            $idTurma = $_POST['ID_TURMA'];

            try {
                Aluno::atualizarTurma($idAluno, $idTurma);
                header('Location: ?pag=turma&metodo=index');
                exit;
            } catch (Exception $e) {
                echo "<script>alert('Erro ao atribuir turma: " . $e->getMessage() . "')</script>";
            }
        }
    }
}

