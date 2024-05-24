<?php

class FrequenciaController
{
    public function index()
    {
        global $parametros;

        // Obter o ano e o mês atual
        $anoAtual = date('Y');
        $mesAtual = date('m');

        // Contar quantos dias tem no mês atual
        $mesQtdDia = cal_days_in_month(CAL_GREGORIAN, $mesAtual, $anoAtual);

        // Obter todos os alunos
        $alunos = Aluno::selecionarTodos();

        $parametros = [
            'alunos' => $alunos,
            'titulo' => 'Frequência',
            'anoAtual' => $anoAtual,
            'mesAtual' => $mesAtual,
            'mesQtdDia' => $mesQtdDia
        ];

        echo TemplateRenderer::render('frequencia.html', $parametros);
    }

    public function marcarPresenca($idTurma = null)
    {
        global $parametros;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $presencas = $_POST['presenca'];
            $idTurma = $_POST['ID_TURMA'];
            foreach ($presencas as $idAluno => $dias) {
                foreach ($dias as $dia => $presenca) {
                    Frequencia::marcarFrequencia($idAluno, $dia, $presenca);
                }
            }

            // Redirecionar após marcar as presenças
            header('Location: ?pag=frequencia');
            exit;
        } else {
            // Obter o ano e o mês atual
            $anoAtual = date('Y');
            $mesAtual = date('m');

            // Contar quantos dias tem no mês atual
            $mesQtdDia = cal_days_in_month(CAL_GREGORIAN, $mesAtual, $anoAtual);

            // Obter todos os alunos
            $alunos = Aluno::selecionarPorTurma($idTurma);

            $parametros = [
                'titulo' => 'Frequência',
                'alunos' => $alunos,
                'id_turma' => $idTurma,
                'anoAtual' => $anoAtual,
                'mesAtual' => $mesAtual,
                'mesQtdDia' => 1 //$mesQtdDia
            ];

            echo TemplateRenderer::render('marcar_frequencia.html', $parametros);
        }
    }
}
