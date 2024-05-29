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

        // Verificar se o ID da turma foi passado via GET ou POST
        $idTurma = isset($_GET['turma']) ? $_GET['turma'] : (isset($_POST['ID_TURMA']) ? $_POST['ID_TURMA'] : null);

        // Consultar a frequência dos alunos de acordo com a turma selecionada
        $frequencias = $idTurma ? Frequencia::consultarFrequencia($idTurma) : [];

        // Obter todos os alunos
        $turmas = Turma::selecionarTodas();
        $alunos = $idTurma ? Aluno::selecionarPorTurma($idTurma) : [];

        $parametros = [
            'titulo' => 'Frequência',
            'alunos' => $alunos,
            'frequencias' => $frequencias,
            'turmas' => $turmas,
            'id_turma' => $idTurma,
            'anoAtual' => $anoAtual,
            'mesAtual' => $mesAtual,
            'mesQtdDia' => $mesQtdDia
        ];

        echo TemplateRenderer::render('frequencia.html', $parametros);
    }


    public function marcarPresenca($idTurma = null)
    {
        global $parametros;

        date_default_timezone_set('America/Sao_Paulo');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $presencas = $_POST['presenca'];

            $idTurma = $_POST['ID_TURMA'];

            foreach ($presencas as $idAluno => $dias) {
                foreach ($dias as $dia => $presenca) {
                    $anoAtual = date('Y');
                    $mesAtual = date('m');
                    $data_aula_str = new DateTime("$anoAtual-$mesAtual-$dia");
                    $data_aula = $data_aula_str->format('Y-m-d');

                    if ($presenca !== "N/A" && $presenca !== "") {
                        // Inserir a presença no banco de dados
                        Frequencia::marcarFrequencia($idAluno, $idTurma, $data_aula, $presenca);
                    }
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

<<<<<<< Updated upstream
            $parametros = [
                'titulo' => 'Frequência',
                'alunos' => $alunos,
                'id_turma' => $idTurma,
                'anoAtual' => $anoAtual,
                'mesAtual' => $mesAtual,
                'mesQtdDia' => 1 //$mesQtdDia
            ];

            echo TemplateRenderer::render('marcar_frequencia.html', $parametros);
=======
                $frequencias = $idTurma ? Frequencia::consultarFrequencia($idTurma) : [];

                // Obter o filtro (dia ou mês)
                $filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'd';
                $data = isset($_GET['data']) ? $_GET['data'] : date('Y-m-d');

                $diaSelecionado = isset($_GET['data']) ? (new DateTime($_GET['data']))->format('d') : date('d');

                $alunos = $idTurma ? Aluno::selecionarPorTurma($idTurma) : [];

                $parametros = [
                    'titulo' => 'Marcar Frequência',
                    'alunos' => $alunos,
                    'turmas' => $turmas,
                    'frequencias' => $frequencias,
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
                        'alunos' => (object)$alunos,
                        'frequencias' => $frequencias
                    ])
                ];

                echo TemplateRenderer::render('marcar_frequencia.html', $parametros);
            } catch (Throwable $e) {
                echo TemplateRenderer::render('marcar_frequencia.html', [
                    'titulo' => 'Erro',
                    'erro' => $e->getMessage(),
                    'alunos' => [],
                    'turmas' => [],
                ]);
            }
>>>>>>> Stashed changes
        }
    }
}
