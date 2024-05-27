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
}
