<?php

class Core
{
    public function run($urlGet)
    {
        $metodo = isset($urlGet['metodo']) ? $urlGet['metodo'] : 'index';

        if (isset($urlGet['pag'])) {
            $controller = ucfirst($urlGet['pag']) . 'Controller';
        } else {
            $controller = 'HomeController';
        }

        if (!class_exists($controller)) {
            $controller = 'ErroController';
        }

        if (!method_exists($controller, $metodo)) {
            $controller = 'ErroController';
            $metodo = 'index';
        }

        $id = isset($urlGet['id']) ? $urlGet['id'] : null;
        $nome = isset($urlGet['nome']) ? $urlGet['nome'] : null;

        try {
            call_user_func_array([new $controller, $metodo], [$id, $nome]);
        } catch (Exception $e) {
            // Em caso de exceção, redirecionar para o ErroController
            $controller = 'ErroController';
            $metodo = 'index';
            $mensagemErro = $e->getMessage();
            call_user_func_array([new $controller, $metodo], [$mensagemErro]);
        }
    }
}
