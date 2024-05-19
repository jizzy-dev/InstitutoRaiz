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
            ob_start();
            call_user_func_array([new $controller, $metodo], [$id, $nome]);
            $saida = ob_get_clean();

            return $saida;
        } catch (Exception $e) {
            $controller = 'ErroController';
            $metodo = 'index';
            $mensagemErro = $e->getMessage();
            ob_start();
            call_user_func_array([new $controller, $metodo], [$mensagemErro]);
            return ob_get_clean();
        }
    }
}
