<?php
class SistemaController
{
    public function index()
    {
        global $parametros;
        $parametros= ['titulo'=>'Sistema'];
        echo TemplateRenderer::render('sistema.html',$parametros);           
    }
}
