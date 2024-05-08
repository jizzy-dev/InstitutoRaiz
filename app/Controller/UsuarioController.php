<?php

class UsuarioController
{
    public function index($params)
    {
        try {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $nomeUsuario = $_POST['nome_responsavel'];
                $emailUsuario = $_POST['email_responsavel'];
                $cpfUsuario = $_POST['cpf_responsavel'];
                $contatoUsuario = $_POST['rg_responsavel'];
                $contatoUsuario = $_POST['contato_responsavel'];
                $cep = $_POST['cep'];
                $logradouro = $_POST['logradouro'];
                $bairro = $_POST['bairro'];
                $numeroEndereco = $_POST['numero_endereco'];
                $complemento = $_POST['complemento'];
                $cidade = $_POST['cidade'];
                $estado = $_POST['estado'];
            }

            $user =  Usuario::selecionarPorId($params);


            $loader = new \Twig\Loader\FilesystemLoader('app/View');
            $twig = new \Twig\Environment($loader);
            $twig->addFunction(new \Twig\TwigFunction('count_keys', function ($obj) {
                return count(get_object_vars($obj));
            }));
            $template = $twig->load('usuario.html');

            $parametros = array();
            $parametros['usuarios'] = $user;

            $conteudo = $template->render($parametros);

            echo $conteudo;

            echo '<pre>';
            var_dump($user);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function showAllUsuarios()
    {
        $user = Usuario::selecionaTodos();

        $loader = new \Twig\Loader\FilesystemLoader('app/View');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('todosUsuarios.html');

        $parametros = array();
        $parametros['usuarios'] = $user;

        $conteudo = $template->render($parametros);
        
        echo $conteudo;
    }
    public function cadastrar()
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
                echo "<script>alert('cadastrado com sucesso!')</script>";
                //header('Location: cadastro_sucesso.html');
                // exit;
            } catch (Exception $e) {
                // Se ocorrer um erro, exibir uma mensagem de erro
                echo 'Erro ao cadastrar usuário: ' . $e->getMessage();
            }
        } else {
            // Se não for uma requisição POST, redirecionar para a página de cadastro
            $loader = new \Twig\Loader\FilesystemLoader('app/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('cadastrar.html');

            $conteudo = $template->render();

            echo $conteudo;
        }
    }
}
