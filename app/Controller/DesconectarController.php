<?php
class DesconectarController{
    public function index(){
        $this->desconectadoSucesso();
        header('refresh:3;url= ?pag=autenticar&metodo=logar');
    }
    public function desconectadoSucesso(){
        $mensagem = 'Desconectado com sucesso!';
        $parametros['mensagem'] = $mensagem; 
        echo TemplateRenderer::render('desconectar.html', $parametros);
    }
}