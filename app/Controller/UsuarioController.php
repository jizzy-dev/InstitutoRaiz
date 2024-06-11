<?php
class UsuarioController
{
    public function index($id = null)
    {
        VerificarSessao::verificarLogin();
        VerificarSessao::verificarPerfil('A');
        global $parametros;
        try {
            $user =  Usuario::selecionarPorId($id);

            $parametros = ['usuarios' => $user, 'titulo' => 'Usuario'];

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
        $parametros = ['titulo' => 'Cadastro de Usuário'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {
                // Verifique se uma imagem foi enviada
                $id_imagem = null;
                if (isset($_FILES['imgInput']) && $_FILES['imgInput']['error'] == 0) {
                    $id_imagem = Imagem::upload($_FILES['imgInput']);
                }

                $emailExiste = ValidarDuplos::verificarEmailDuplo($_POST['email_responsavel']);
                if ($emailExiste) {
                    $erro = 'O e-mail informado já está em uso';
                    $parametros = [
                        'erro' => $erro,
                        'login_redirect' => true
                    ];
                }

                $cpfExiste = ValidarDuplos::verificarCPFDuplo($_POST['cpf_responsavel']);
                if ($cpfExiste) {
                    $erro = 'O CPF informado já está em uso';
                    $parametros = [
                        'erro' => $erro,
                        'login_redirect' => true
                    ];
                }

                if ($emailExiste && $cpfExiste) {
                    $erro = "Os seguintes campos informados já estão cadastrados:\n Email, CPF";
                    $parametros = [
                        'erro' => $erro,
                        'login_redirect' => true
                    ];
                }

                $dadosUser = [
                    'nome' => htmlspecialchars($_POST['nome_responsavel']),
                    'cpf' => htmlspecialchars($_POST['cpf_responsavel']),
                    'rg' => htmlspecialchars($_POST['rg_responsavel']),
                    'contato' => htmlspecialchars($_POST['contato_responsavel']),
                    'email' => htmlspecialchars($_POST['email_responsavel']),
                    'senha' => htmlspecialchars($_POST['senha_responsavel']),
                    'data_nasc' => htmlspecialchars($_POST['data_nasc_responsavel']),
                    'cep' => htmlspecialchars($_POST['cep']),
                    'logradouro' => htmlspecialchars($_POST['logradouro']),
                    'bairro' => htmlspecialchars($_POST['bairro']),
                    'numero_endereco' => htmlspecialchars($_POST['numero_endereco']),
                    'complemento' => htmlspecialchars($_POST['complemento']),
                    'cidade' => htmlspecialchars($_POST['cidade']),
                    'estado' => htmlspecialchars($_POST['estado']),
                    'isResponsavel' => isset($_POST['isResponsavel']) ? 1 : 0,
                    'isPadrinho' => isset($_POST['isPadrinho']) ? 1 : 0,
                    'perfil_acesso' => isset($_POST['perfil_acesso']) ? $_POST['perfil_acesso'] : 'U',
                    'ID_IMAGEM' => $id_imagem
                ];

                Usuario::Create($dadosUser);
                // Redirecionar o usuário para uma página de confirmação
                $resultado = 'Cadastro feito com Sucesso!';
                $parametros['resultado'] = $resultado;

                echo TemplateRenderer::render('cadastro_sucesso.html', $parametros);
            } catch (Exception $e) {
                // Se ocorrer um erro, exibir uma mensagem de erro
                // $this->handleError('Erro ao cadastrar usuário: ' . $e->getMessage());
                echo TemplateRenderer::render('cadastrar_usuario.html', $parametros);
            }
        } else {
            // Se não for uma requisição POST, redirecionar para a página de cadastro
            echo TemplateRenderer::render('cadastrar_usuario.html', $parametros);
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
                $parametros = ['usuarios' => $user, 'titulo' => 'Consultar Usuário', 'erro' => ''];
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
        // VerificarSessao::verificarLogin();
        global $parametros;
        $id = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $user = Usuario::selecionarPorId($id);
                $id_imagem = $user->ID_IMAGEM;

                if (isset($_FILES['imgInput']) && $_FILES['imgInput']['error'] == 0) {
                    $id_imagem = Imagem::uploadUpdate($_FILES['imgInput'], $id_imagem);
                }

                $dados = [
                    'id' => htmlspecialchars($id),
                    'nome' => htmlspecialchars($_POST['nome_responsavel']),
                    'cpf' => htmlspecialchars($_POST['cpf_responsavel']),
                    'rg' => htmlspecialchars($_POST['rg_responsavel']),
                    'contato' => htmlspecialchars($_POST['contato_responsavel']),
                    'email' => htmlspecialchars($_POST['email_responsavel']),
                    'senha' => htmlspecialchars($_POST['senha_responsavel']),
                    'data_nasc' => htmlspecialchars($_POST['data_nasc_responsavel']),
                    'cep' => htmlspecialchars($_POST['cep']),
                    'logradouro' => htmlspecialchars($_POST['logradouro']),
                    'bairro' => htmlspecialchars($_POST['bairro']),
                    'numero_endereco' => htmlspecialchars($_POST['numero_endereco']),
                    'complemento' => htmlspecialchars($_POST['complemento']),
                    'cidade' => htmlspecialchars($_POST['cidade']),
                    'estado' => htmlspecialchars($_POST['estado']),
                    'isResponsavel' => isset($_POST['isResponsavel']) ? 1 : 0,
                    'isPadrinho' => isset($_POST['isPadrinho']) ? 1 : 0,
                    'ID_IMAGEM' => $id_imagem
                ];

                Usuario::atualizarPorId($dados);
                echo "<script>alert('Usuário atualizado com sucesso!'); window.location.href = '?pag=usuario&metodo=index&id=" . $id . "';</script>";
            } catch (Exception $e) {
                echo "<script>alert('Erro ao editar usuário: " . $e->getMessage() . "')</script>";
            }
        } else {
            if ($id !== null) {
                try {
                    $user = Usuario::selecionarPorId($id);
                    $imagem = Imagem::selecionarPorId($user->ID_IMAGEM);
                    $parametros = ['usuario' => $user, 'imagem' => $imagem, 'titulo' => 'Editar Usuário'];
                    echo TemplateRenderer::render('editar_usuario.html', $parametros);
                } catch (Exception $e) {
                    echo "<script>alert('Erro ao editar usuário: " . $e->getMessage() . "')</script>";
                }
            } else {
                header('Location: ?pag=usuario&metodo=consultar');
                exit;
            }
        }
    }
    public function atribuirAcesso()
    {
        VerificarSessao::verificarLogin();
        VerificarSessao::verificarPerfil('A');

        global $parametros;

        $id = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : ($_GET['id'] ? $_GET['id'] : 1);
        $perfil_acesso = isset($_POST['perfil_acesso']) ? $_POST['perfil_acesso'] : null;

        $user = Usuario::selecionarPorId($id);
        $parametros['usuario'] = $user;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {

                $dados = [
                    'id' => htmlspecialchars($id),
                    'perfil_acesso' => htmlspecialchars($perfil_acesso)
                ];
                $parametros = [
                    'titulo' => 'Atribuir Acesso',
                    'ModalTipo' => 'Mensagem',
                    'mensagem' => 'Atribuição de Perfil feita com Sucesso!'
                ];
                Usuario::atualizarPerfilAcesso($dados);
                echo TemplateRenderer::render('atribuir_perfil_acesso.html', $parametros);
            } catch (Exception $e) {
                echo "<script>alert('Erro ao editar usuário: " . $e->getMessage() . "')</script>";
            }
        } else {
            echo TemplateRenderer::render('atribuir_perfil_acesso.html', $parametros);
        }
    }

    private function handleError($errorMessage)
    {
        $erroController = new ErroController();
        $erroController->index($errorMessage);
    }
}
