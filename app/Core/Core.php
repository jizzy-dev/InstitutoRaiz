<?php
class Core
{
    public function run($urlGet)
    {
        global $parametros;
        $metodo = isset($urlGet['metodo']) ? $urlGet['metodo'] : 'index';

        if (isset($urlGet['pag'])) {
            $controller = ucfirst($urlGet['pag']) . 'Controller';
        } else {
            $controller = 'HomeController';
        }

        if (!class_exists($controller)) {
            $controller = 'ErroController';
            $parametros['erro'] = "Essa página não existe.";
        }

        if (!method_exists($controller, $metodo)) {
            $controller = 'ErroController';
            $metodo = 'index';
        }

        $id = isset($urlGet['id']) && $urlGet['id'] !== null ? $urlGet['id'] : null;
        $nome = isset($urlGet['nome']) && $urlGet['nome'] !== null ? $urlGet['nome'] : null;

        call_user_func_array(array(new $controller, $metodo), array($id, $nome));
    }
}
