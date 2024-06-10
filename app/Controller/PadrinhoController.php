<?php
class PadrinhoController
{
    public function index($id = null)
    {
        global $parametros;
        try {
            $user =  Usuario::selecionarPorId($id);

            $parametros = ['usuarios' => $user, 'titulo' => 'Padrinho'];

            echo TemplateRenderer::render('padrinho.html', $parametros);

            // echo '<pre>';
            // var_dump($parametros);
        } catch (Exception $e) {
            echo TemplateRenderer::render('padrinho.html', ['erro' => $e->getMessage(), 'usuarios' => [], 'titulo' => 'Erro']);
        }
    }
    public function Cadastrar()
    {
        global $parametros;
        $parametros = ['titulo' => 'Apadrinhamento'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome' => $_POST['nome_padrinho'],
                'cpf' => $_POST['cpf_padrinho'],
                'rg' => $_POST['rg_padrinho'],
                'contato' => $_POST['contato_padrinho'],
                'email' => $_POST['email_padrinho'],
                'senha' => $_POST['senha_padrinho'],
                'data_nasc' => $_POST['data_nasc_padrinho'],
                'cep' => $_POST['cep'],
                'logradouro' => $_POST['logradouro'],
                'bairro' => $_POST['bairro'],
                'numero_endereco' => $_POST['numero_endereco'],
                'complemento' => $_POST['complemento'],
                'cidade' => $_POST['cidade'],
                'estado' => $_POST['estado'],
                'isResponsavel' => isset($_POST['isResponsavel']) ? 1 : 0, // Marcar como responsável se o campo estiver presente
                'isPadrinho' => 1,
                'isAdm' => 0, // Por padrão, não é um administrador
                'isMod' => 0, // Por padrão, não é um moderador
                'ID_IMAGEM' => 1
            ];

            // Chamar o método cadastrar do modelo Usuario
            try {
                Usuario::Create($dados);
                // Redirecionar o usuário para uma página de confirmação
                echo TemplateRenderer::render('cadastro_sucesso.html');
            } catch (Exception $e) {
                // Se ocorrer um erro, exibir uma mensagem de erro
                $this->handleError('Erro ao cadastrar usuário: ' . $e->getMessage());
            }
        } else {
            // Se não for uma requisição POST, redirecionar para a página de cadastro
            echo TemplateRenderer::render('cadastrar_padrinho.html', $parametros);
        }
    }
    public function Consultar($nome = null)
    {
        global $parametros;
        try {
            $nomeUsuario =  isset($_POST['filtro']) ?
                $_POST['filtro'] : $_POST['filtro'] = null;

            if ($nome !== null) {
                $nomeUsuario = $nome;
            }

            $user =  Usuario::selecionarPadrinhos();

            if ($user === null) {
                // Renderizar a página com a mensagem de erro
                echo TemplateRenderer::render('consultar_padrinho.html', ['erro' => 'Nenhum usuário encontrado', 'usuarios' => []]);
            } else {
                // Renderizar a página com os resultados da consulta
                $parametros = ['usuarios' => $user, 'titulo' => 'Consultar Padrinho', 'erro' => ''];

                echo TemplateRenderer::render('consultar_padrinho.html', $parametros);
            }
        } catch (Exception $e) {
            // Mostrar mensagem de erro genérica
            echo TemplateRenderer::render('consultar_padrinho.html', ['erro' => $e->getMessage(), 'usuarios' => []]);
        }
    }
    public function atribuirPadrinho($id = null)
    {
        global $parametros;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dadosPadrinho = [
                'id_padrinho' => $_POST['id_padrinho'],
                'isPadrinho' => 1 //true
            ];
            try {
                // Atualiza o status do usuário para padrinho
                Usuario::bindPadrinho($dadosPadrinho);

                // Vincula o aluno ao padrinho
                $dadosAluno = [
                    'id' => $_POST['id_aluno'],
                    'ID_USER_PADRINHO' => $_POST['id_padrinho']
                ];

                Aluno::bindPadrinho($dadosAluno);

                header('Location: ?pag=padrinho&metodo=Consultar');
                exit;
            } catch (Exception $e) {
                echo "<script>alert('Erro ao vincular Padrinho: " . $e->getMessage() . "')</script>";
            }
        } else {
            if ($id !== null) {
                try {
                    $user = Usuario::selecionarPadrinhoPorId($id);
                    $aluno = Aluno::selecionarPorId(3);
                    $parametros = [
                        'usuario' => $user,
                        'aluno' => $aluno,
                        'titulo' => 'Atribuir Padrinho',
                        'alunoObject' => json_encode((object)[
                            'aluno' => $aluno
                        ])
                    ];
                    // echo "<pre>";
                    // var_dump($parametros['aluno']);
                    // echo '</pre>';
                    echo TemplateRenderer::render('atribuir_padrinho.html', $parametros);
                } catch (Exception $e) {
                    echo "<script>alert('Erro ao carregar dados: " . $e->getMessage() . "')</script>";
                }
            }
        }
    }
    public function buscarNomeAluno()
    {
        if (isset($_POST['id_aluno'])) {
            $idAluno = $_POST['id_aluno'];
            try {
                $aluno = Aluno::selecionarPorId($idAluno);
                if ($aluno) {

                    // Renderiza o JSON dentro do template 'noDOM'
                    echo TemplateRenderer::render('noDOM.html', ['aluno' => $aluno]);
                } else {
                    echo 'Aluno não encontrado';
                }
            } catch (Exception $e) {
                echo 'Erro ao buscar nome do aluno: ' . $e->getMessage();
            }
        } else {
            echo 'ID do aluno não fornecido';
        }
    }

    private function handleError($errorMessage)
    {
        $erroController = new ErroController();
        $erroController->index($errorMessage);
    }
}
