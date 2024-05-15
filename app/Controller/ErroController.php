<?php

class ErroController
{
    public function index($erro)
    {
        echo TemplateRenderer::render('erro.html', ['erro' => $erro]);
    }
}
