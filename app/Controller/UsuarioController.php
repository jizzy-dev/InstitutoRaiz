<?php

class UsuarioController{
    public function index(){
        try {
            $exibirUsuarios =  Usuario::selecionaTodos();


            $loader= new \Twig\Loader\FilesystemLoader('app/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('usuario.html');

            $parametros = array();
            $parametros['usuarios'] = $exibirUsuarios; 
            
            $conteudo = $template->render($parametros);

            echo $conteudo;

        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }
}