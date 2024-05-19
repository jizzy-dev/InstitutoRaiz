<?php
class HomeController
{
    public function index()
    {
        $titulo = 'Página Home';
        echo TemplateRenderer::render('home.html', ['titulo'=> $titulo]);
    }
}
