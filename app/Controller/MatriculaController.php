<?php
class MatriculaController
{
    public function index()
    {
        $parametros = ['titulo' => 'Matrícula'];
        echo TemplateRenderer::render('matricula.html', $parametros);
    }
    public function Cadastrar()
    {
        global $parametros;
        $parametros = ['titulo' => 'Matrícula'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email_responsavel'];
            $cpf = $_POST['cpf_responsavel'];

            // Verifica se o e-mail ou CPF já existem
            $emailExiste = ValidarDuplos::verificarEmailDuplo($email);
            $cpfExiste = ValidarDuplos::verificarCPFDuplo($cpf);

            // Se o e-mail ou CPF já existem, exibe uma mensagem de erro
            if ($emailExiste || $cpfExiste) {
                $ModalTipo = 'Erro';
                $erro = '';
                if ($emailExiste) {
                    $erro .= 'O e-mail informado já está em uso. ';
                }
                if ($cpfExiste) {
                    $erro .= 'O CPF informado já está em uso.';
                }
                $parametros = [
                    'ModalTipo' => 'Erro',
                    'erro' => $erro,
                ];
                echo TemplateRenderer::render('cadastrar_matricula.html', $parametros);
                return; // Encerra a execução do método para evitar a tentativa de inserção de registro duplicado
            }
            $dadosUsuario = Validador::limparDados([
                'nome' => $_POST['nome_responsavel'],
                'cpf' => $_POST['cpf_responsavel'],
                'rg' => $_POST['rg_responsavel'],
                'contato' => $_POST['contato_responsavel'],
                'email' => $_POST['email_responsavel'],
                'senha' => $_POST['senha_responsavel'],
                'data_nasc' => $_POST['data_nasc_responsavel'],
                'cep' => $_POST['cep'],
                'logradouro' => $_POST['logradouro'],
                'bairro' => $_POST['bairro'],
                'numero_endereco' => $_POST['numero_endereco'],
                'complemento' => $_POST['complemento'],
                'cidade' => $_POST['cidade'],
                'estado' => $_POST['estado'],
                'isResponsavel' => 1,
                'isPadrinho' => isset($_POST['isPadrinho']) ? 1 : 0, // Marcar como padrinho se o campo estiver presente
                'isAdm' => 0, // Por padrão, não é um administrador
                'isMod' => 0, // Por padrão, não é um moderador
                'ID_IMAGEM' => 1
            ]);
            try {
                $id_usuario = Usuario::Create($dadosUsuario);

                $dadosAluno = Validador::limparDados([
                    'nome' => $_POST['nome_aluno'],
                    'cpf' => $_POST['cpf_aluno'],
                    'rg' => $_POST['rg_aluno'],
                    'data_nasc' => $_POST['data_nasc_aluno'],
                    'certidao' => $_POST['certidao_aluno'],
                    'carteira_vacina' => $_POST['carteira_vacina_aluno'],
                    'situacao_matricula' => isset($_POST['situacao_matricula']) ? $_POST['situacao_matricula'] : 'pendente',
                    'data_matricula' => date('Y-m-d h:i:s'),
                    'data_inicio' => isset($_POST['data_inicio']) ? $_POST['data_inicio'] : date('Y-m-d h:i:s'),
                    'ID_TURMA' => isset($_POST['ID_TURMA']) ? $_POST['ID_TURMA'] : 1,
                    'ID_USER_RESPONSAVEL' => $id_usuario,
                    'ID_USER_PADRINHO' => isset($_POST['ID_USER_PADRINHO']) ? $_POST['ID_USER_PADRINHO'] : 1
                ]);

                Aluno::Create($dadosAluno);

                $resultado = 'Cadastro feito com Sucesso!';
                $parametros['resultado'] = $resultado;

                echo TemplateRenderer::render('cadastro_sucesso.html', $parametros);
            } catch (Exception $e) {
                $this->handleError('Erro ao cadastrar matrícula: ' . $e->getMessage());
            }
        } else {

            echo TemplateRenderer::render('cadastrar_matricula.html', $parametros);
        }
    }
    public function Consultar($nome = null)
    {
        global $parametros;
        try {
            $nomeAluno = isset($_POST['filtro']) ? $_POST['filtro'] : $nome;
            $situcao = isset($_POST['situacao']) ? $_POST['situacao'] : (isset($_GET['situacao'])? $_GET['situacao'] : null);

            $alunos = Aluno::filtrarNomeSitucao($nomeAluno, $situcao);

            $parametros = ['alunos' => $alunos, 'titulo' => 'Consultar Matrícula', 'situacao' => $situcao, 'erro' => ''];
            echo TemplateRenderer::render('consultar_matricula.html', $parametros);
        } catch (Exception $e) {
            echo TemplateRenderer::render('consultar_matricula.html', ['erro' => $e->getMessage(), 'alunos' => []]);
        }
    }
    public function validarMatricula($id, $aprovar)
    {
        global $parametros;
        $parametros['titulo'] = 'Aprovar Matrícula';

        $id = $_GET['id'];
        if (isset($_GET['redirect'])) {
            if ($_GET['redirect'] === 'aprovar') {
                $aprovar = true;
            } elseif ($_GET['redirect'] === 'reprovar') {
                $aprovar = false;
            }


            if ($aprovar === true) {
                $parametros = [
                    'ModalTipo' => 'YesNo',
                    'YesNoAnchor' => true,
                    'pag' => 'matricula',
                    'mensagem' => 'Deseja Realmente Aprovar essa Matrícula?',
                    'hrefLink' => '?pag=matricula&metodo=aprovarmatricula&id='."$id".'&acao=aprovar',
                    'id' => $id
                ];
                echo TemplateRenderer::render('consultar_matricula.html', $parametros);
            } else {
                $parametros = [
                    'ModalTipo' => 'YesNo',
                    'YesNoAnchor' => true,
                    'pag' => 'matricula',
                    'mensagem' => 'Deseja Realmente Reprovar essa Matrícula?',
                    'hrefLink'=>'?pag=matricula&metodo=aprovarmatricula&id='."$id".'&acao=reprovar',
                    'id' => $id
                ];
                echo TemplateRenderer::render('consultar_matricula.html', $parametros);
            }
        }
    }
    public function aprovarMatricula($id)
    {
        global $parametros;
        $parametros['titulo'] = 'Aprovar Matrícula';

        $id = $_GET['id'];
        if (isset($_GET['acao'])) {
            if ($_GET['acao'] === 'aprovar') {
                $aprovar = true;
                $situacao = 'aprovado';
            } elseif ($_GET['acao'] === 'reprovar') {
                $aprovar = false;
                $situacao = 'reprovado';
            }
            try {
                $dados = [
                    'id' => $id,
                    'situacao' => $situacao
                ];
                if ($aprovar === true) {
                    Aluno::aprovarMatricula($dados);
                    $parametros = ['ModalTipo' => 'Mensagem', 'mensagem' => 'Matrícula Aprovado com Sucesso'];
                    echo TemplateRenderer::render('consultar_matricula.html', $parametros);
                } else {
                    $parametros = ['ModalTipo' => 'Mensagem', 'mensagem' => "$situacao".'Matrícula Reprovada com Sucesso'];
                    echo TemplateRenderer::render('consultar_matricula.html', $parametros);
                    Aluno::aprovarMatricula($dados);
                }
            } catch (Exception $e) {
                echo TemplateRenderer::render('consultar_matricula.html', ['ModalTipo' => 'Erro', 'erro' => $e->getMessage(), 'alunos' => []]);
            }
        }
    }
    private function handleError($errorMessage)
    {
        $erroController = new ErroController();
        $erroController->index($errorMessage);
    }
}
