<?php

class ErroController
{
    public function index($erro)
    {
        if(!$erro){
            $erro = "Erro 404. Página não encontrada";
        }
        echo TemplateRenderer::render('erro.html', ['erro' => $erro , 'titlo'=>'Error']);
    }
    public function acesso($result){
       
       $result = $_GET['allowed'];

        if($result == 'false'){

            $erro = "Erro: Acesso Negado!";
            echo TemplateRenderer::render('erro.html', ['erro' => $erro , 'titlo'=>'Acesso Negado']);
        }else{
            header('Location: ?pag=home');
            exit;
        }
    }
}
