<?php
class UsuarioController
{
    public function index($id = null)
    {
        global $parametros;
        try {
            $user =  Usuario::selecionarPorId($id);

            $parametros = ['usuarios' => $user,'titulo'=>'Usuario'];

            echo TemplateRenderer::render('usuario.html', $parametros);

            // echo '<pre>';
            // var_dump($parametros);
        } catch (Exception $e) {
            echo TemplateRenderer::render('usuario.html', ['erro' => $e->getMessage(), 'usuarios' => [], 'titulo' => 'Erro']);
        }
    }
    public function Cadastrar()
    {
        global $parametros;
        $parametros = ['titulo' =>'Matrícula'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
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
                'isResponsavel' => isset($_POST['isResponsavel']) ? 1 : 0, // Marcar como responsável se o campo estiver presente
                'isPadrinho' => isset($_POST['isPadrinho']) ? 1 : 0, // Marcar como padrinho se o campo estiver presente
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
                $this->handleError('Erro ao cadastrar usuário: ' .$e->getMessage());
            }
        } else {
            // Se não for uma requisição POST, redirecionar para a página de cadastro
            echo TemplateRenderer::render('cadastrar.html',$parametros);
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

            $user =  Usuario::filtrar($nomeUsuario);

            if ($user === null) {
                // Renderizar a página com a mensagem de erro
                echo TemplateRenderer::render('consultar_usuario.html', ['erro' => 'Nenhum usuário encontrado', 'usuarios' => []]);
            } else {
                // Renderizar a página com os resultados da consulta
                $parametros = ['usuarios' => $user,'titulo'=>'Consultar', 'erro' => ''];
                echo TemplateRenderer::render('consultar_usuario.html', $parametros);
            }
        } catch (Exception $e) {
            // Mostrar mensagem de erro genérica
            echo TemplateRenderer::render('consultar_usuario.html', ['erro' => $e->getMessage(), 'usuarios' => []]);
        }
    }
    public function Excluir($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_usuario'];

            try {
                Usuario::deletarPorId($id);
                header('Location: ?pag=usuario&metodo=consultar');
                exit;
            } catch (Exception $e) {
                echo "<script>alert('Erro ao excluir usuário: " . $e->getMessage() . "')</script>";
            }
        }
    }
    public function Editar($id = null)
    {
        global $parametros;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Se for uma requisição POST, atualizar o usuário
            $dados = [
                'id' => $_POST['id_usuario'],
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
                'isResponsavel' => isset($_POST['isResponsavel']) ? 1 : 0,
                'isPadrinho' => isset($_POST['isPadrinho']) ? 1 : 0,
                'isAdm' => 0,
                'isMod' => 0,
                'ID_IMAGEM' => 1
            ];
            try {
                Usuario::atualizarPorId($dados);
                // Redirecionar para a página de consulta após a atualização
                header('Location: ?pag=usuario&metodo=consultar');
                exit;
            } catch (Exception $e) {
                echo "<script>alert('Erro ao editar usuário: " . $e->getMessage() . "')</script>";
            }
        } else {
            // Se não for uma requisição POST, verificar se o ID do usuário está presente na URL
            if ($id !== null) {
                try {
                    // Obter o ID do usuário da URL
                    $id = $_GET['id']; // Supondo que o ID do usuário seja passado na URL
                    // Selecionar o usuário pelo ID
                    $user = Usuario::selecionarPorId($id);
                    $parametros = ['usuario' => $user,'titulo' => 'Editar Usuário'];
                    // Renderizar a view de edição e passar os dados do usuário
                    echo TemplateRenderer::render('editar_usuario.html', $parametros);
                } catch (Exception $e) {
                    echo "<script>alert('Erro ao editar usuário: " . $e->getMessage() . "')</script>";
                }
            } else {
                // Se o ID do usuário não estiver presente na URL, redirecionar para a página de consulta
                header('Location: ?pag=usuario&metodo=consultar');
                exit;
            }
        }
    }
    private function handleError($errorMessage) {
        $erroController = new ErroController();
        $erroController->index($errorMessage);
    }
}
