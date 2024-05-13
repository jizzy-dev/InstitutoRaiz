<?php
class UsuarioController
{
    public function index($id)
    {
        try {
            $user =  Usuario::selecionarPorId($id);

            $parametros = ['usuarios' => $user];

            echo TemplateRenderer::render('usuario.html', $parametros);

            echo '<pre>';
            var_dump($user);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function Cadastrar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome' => $_POST['nome_responsavel'],
                'cpf' => $_POST['cpf_responsavel'],
                'rg' => $_POST['rg_responsavel'],
                'contato' => $_POST['contato_responsavel'],
                'email' => $_POST['email_responsavel'],
                'senha' => $_POST['senha_responsavel'], // Lembre-se de implementar a lógica de segurança para as senhas
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
                'ID_IMAGEM' => 1 // Defina o ID da imagem conforme necessário
            ];

            // Chamar o método cadastrar do modelo Usuario
            try {
                Usuario::cadastrar($dados);
                // Redirecionar o usuário para uma página de confirmação
                echo TemplateRenderer::render('cadastro_sucesso.html');
            } catch (Exception $e) {
                // Se ocorrer um erro, exibir uma mensagem de erro
                echo 'Erro ao cadastrar usuário: ' . $e->getMessage();
            }
        } else {
            // Se não for uma requisição POST, redirecionar para a página de cadastro
            echo TemplateRenderer::render('cadastrar.html');
        }
    }
    public function Consultar($nome)
    {
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
                $parametros = ['usuarios' => $user, 'erro' => ''];
                echo TemplateRenderer::render('consultar_usuario.html', $parametros);
            }
        } catch (Exception $e) {
            // Mostrar mensagem de erro genérica
            echo TemplateRenderer::render('consultar_usuario.html', ['erro' => $e->getMessage(), 'usuarios' => []]);
        }
    }

    public function Excluir($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_usuario'];

            try {
                Usuario::deletarPorId($id);
                header('Location: ?pag=usuario&metodo=consultar');
                exit;
            } catch (Exception $e) {
                echo "<script>alert('Erro ao excluir usuário: " . $e->getMessage()."')</script>";
            }
        }
    }
}
