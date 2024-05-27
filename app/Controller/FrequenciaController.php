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
            $this->index();
        } else {
            try {
                // Obter o ano e o mês atual
                $anoAtual = date('Y');
                $mesAtual = date('m');
                $diaAtual = date('d');
                $diaSelecionado = null;
                // Contar quantos dias tem no mês atual
                $mesQtdDia = cal_days_in_month(CAL_GREGORIAN, $mesAtual, $anoAtual);

                // Obter todos os alunos
                $turmas = Turma::selecionarTodas();

                // Verificar se o ID da turma foi passado via GET ou POST
                $idTurma = isset($_GET['turma']) ? $_GET['turma'] : (isset($_POST['ID_TURMA']) ? $_POST['ID_TURMA'] : null);

                // Obter o filtro (dia ou mês)
                $filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'd';
                $data = isset($_GET['data']) ? $_GET['data'] : date('Y-m-d');

                $diaSelecionado = isset($_GET['data']) ? $_GET['data'] : date('d');

                $alunos = $idTurma ? Aluno::selecionarPorTurma($idTurma) : [];

                $parametros = [
                    'titulo' => 'Frequência',
                    'alunos' => $alunos,
                    'turmas' => $turmas,
                    'id_turma' => $idTurma,
                    'anoAtual' => $anoAtual,
                    'mesAtual' => $mesAtual,
                    'diaAtual' => $diaAtual,
                    'mesQtdDia' => $mesQtdDia,
                    'filtroRadio' => $filtro,
                    'diaSelecionado' => $diaSelecionado,
                    'data' => $data,
                    'dataFrequenciaObject' => json_encode((object) [
                        'dia' => $diaSelecionado,
                        'mes' => $mesQtdDia,
                        'alunos' => (object)$alunos
                    ])
                ];
                echo '<pre>';
                print_r($parametros);
                echo '</pre>';

                
                echo TemplateRenderer::render('marcar_frequencia.html', $parametros);
            } catch (Exception $e) {
                echo TemplateRenderer::render('marcar_frequencia.html', [
                    'titulo' => 'Erro',
                    'erro' => $e->getMessage(),
                    'alunos' => [],
                    'turmas' => [],
                ]);
            }
        }
    }
}
