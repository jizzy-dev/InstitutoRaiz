<?php
class SistemaController
{
    private array $perfisNecessarios;

    public function __construct()
    {
        VerificarSessao::verificarLogin();
        $this->perfisNecessarios = ['A', 'M', 'D']; // Perfis padrão
    }
    public function index()
    {
        global $parametros;
        $parametros = ['titulo' => 'Sistema'];
        echo TemplateRenderer::render('sistema.html', $parametros);
    }
    public function redirectPag()
    {
        global $parametros;
        $titulo = isset($_GET['titulo']) ? $_GET['titulo'] : Null;
        $pagAtual = isset($_GET['atual']) ? $_GET['atual'] : Null;
        $pagRedirect = isset($_GET['redirecionar']) ? $_GET['redirecionar'] : Null;
        $permissao = isset($_GET['permissao']) ? $_GET['permissao'] : Null;

        if ($permissao !== null && $permissao === 'necessaria') {
            $parametros = [
                'titulo' => $titulo,
                'ModalTipo' => 'Mensagem',
                'mensagem' => 'Permissão Necessária !'
            ];
            echo TemplateRenderer::render('sistema_' . "$pagAtual" . '.html', $parametros);
        } elseif ($permissao === 'permitido') {
            header('Location: ?pag=usuario&metodo=atribuirAcesso');
        } else {

            $parametros = ['titulo' => $titulo];
            echo TemplateRenderer::render('sistema_' . "$pagRedirect" . '.html', $parametros);
        }
    }
    private function alterarPerfisNecessarios(array $novosPerfis)
    {
        $this->perfisNecessarios = $novosPerfis;
        VerificarSessao::verificarPerfil($this->perfisNecessarios);
    }
}
