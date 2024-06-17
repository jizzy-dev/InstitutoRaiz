<?php
class AutenticarController
{
    public function index()
    {
        $this->logarComCPF();
    }

public function logarComCPF(bool $isCPFLogin = null){
    if ($isCPFLogin == true && $isCPFLogin) {
        $dados['cpf'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    }else{
        $dados['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    }
    $this->Logar();
}

    public function Logar()
    {
        global $parametros;
        $parametros = ['titulo' => 'Login'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            $dados = [
                'senha' => $_POST['senha'] ?? ''
            ];
            
            

            try {
                $user =  Autenticar::login($dados);
                $imagem = Imagem::selecionarPorId($user->ID_IMAGEM);
                $_SESSION['user'] = $user;
                $_SESSION['imagem'] = $imagem;

                header('Location: ?pag=home');
                exit;
            } catch (Exception $e) {
                $parametros = [
                    'ModalTipo'=>'Erro',
                    'erro' => $e->getMessage(),
                ];
                echo TemplateRenderer::render('login.html', $parametros);
                session_destroy();
            }
        } else {
            $parametros = ['titulo' => 'Login'];
            echo TemplateRenderer::render('login.html', $parametros);
        }
    }
    public function Sair()
    {
        session_destroy();
        header('Location: ?pag=desconectar');
    }
}
