<?php
class HomeController
{
    public function index()
    {
        // global $parametros;
        // $parametros = ['titulo'=> 'Home'];
        echo TemplateRenderer::render('home.html');
    }
}
