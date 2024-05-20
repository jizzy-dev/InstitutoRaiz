<?php
class AlunoController
{
    public function index($id = null)
    {
        global $parametros;

        try {
            $aluno = Aluno::selecionarPorId($id);

            $parametros = ['alunos' => $aluno, 'titulo' => 'Aluno'];

            echo TemplateRenderer::render('aluno.html', $parametros);
        } catch (Exception $e) {
            echo TemplateRenderer::render('aluno.html', ['erro' => $e->getMessage(), 'alunos' => [], 'titulo' => 'Erro']);
        }
    }

    public function Cadastrar()
    {
        global $parametros;
        $parametros = ['titulo' => 'Cadastro de Aluno'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome' => $_POST['nome_aluno'],
                'cpf' => $_POST['cpf_aluno'],
                'rg' => $_POST['rg_aluno'],
                'data_nasc' => $_POST['data_nasc_aluno'],
                'certidao' => $_POST['certidao'],
                'carteira_vacina' => $_POST['carteira_vacina'],
                'situacao_matricula' => $_POST['situacao_matricula'],
                'data_matricula' => $_POST['data_matricula'],
                'data_inicio' => $_POST['data_inicio'],
                'ID_TURMA' => $_POST['ID_TURMA'],
                'ID_USER_RESPONSAVEL' => $_POST['ID_USER_RESPONSAVEL'],
                'ID_USER_PADRINHO' => $_POST['ID_USER_PADRINHO']
            ];

            try {
                Aluno::Create($dados);
                echo TemplateRenderer::render('cadastro_sucesso.html');
            } catch (Exception $e) {
                $this->handleError('Erro ao cadastrar aluno: ' . $e->getMessage());
            }
        } else {
            echo TemplateRenderer::render('cadastrar_aluno.html', $parametros);
        }
    }

    public function Consultar($nome = null)
    {
        global $parametros;
        try {
            $nomeAluno = isset($_POST['filtro']) ? $_POST['filtro'] : $nome;

            $alunos = Aluno::filtrar($nomeAluno);

            $parametros = ['alunos' => $alunos, 'titulo' => 'Consultar Aluno', 'erro' => ''];
            echo TemplateRenderer::render('consultar_aluno.html', $parametros);
        } catch (Exception $e) {
            echo TemplateRenderer::render('consultar_aluno.html', ['erro' => $e->getMessage(), 'alunos' => []]);
        }
    }

    public function Excluir($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['ID_ALUNO'];
            try {
                Aluno::deletarPorId($id);
                header('Location: ?pag=aluno&metodo=consultar');
                exit;
            } catch (Exception $e) {
                $this->handleError('Erro ao excluir aluno: ' . $e->getMessage());
            }
        }
    }

    public function Editar($id = null)
    {
        global $parametros;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'id' => $_POST['ID_ALUNO'],
                'nome' => $_POST['nome_aluno'],
                'cpf' => $_POST['cpf_aluno'],
                'rg' => $_POST['rg_aluno'],
                'data_nasc' => $_POST['data_nasc_aluno'],
                'certidao' => $_POST['certidao'],
                'carteira_vacina' => $_POST['carteira_vacina'],
                'situacao_matricula' => $_POST['situacao_matricula'],
                'data_matricula' => $_POST['data_matricula'],
                'data_inicio' => $_POST['data_inicio'],
                'ID_TURMA' => $_POST['ID_TURMA'],
                'ID_USER_RESPONSAVEL' => $_POST['ID_USER_RESPONSAVEL'],
                'ID_USER_PADRINHO' => $_POST['ID_USER_PADRINHO']
            ];

            try {
                Aluno::atualizarPorId($dados);
                echo TemplateRenderer::render('editar_sucesso.html');
            } catch (Exception $e) {
                $this->handleError('Erro ao atualizar aluno: ' . $e->getMessage());
            }
        } else {
            try {
                $aluno = Aluno::selecionarPorId($id);
                $parametros = ['aluno' => $aluno, 'titulo' => 'Editar Aluno'];
                echo TemplateRenderer::render('editar_aluno.html', $parametros);
            } catch (Exception $e) {
                echo TemplateRenderer::render('editar_aluno.html', ['erro' => $e->getMessage()]);
            }
        }
    }

    private function handleError($errorMessage)
    {
        global $parametros;
        $parametros = ['erro' => $errorMessage];
        echo TemplateRenderer::render('erro.html', $parametros);
    }
}
