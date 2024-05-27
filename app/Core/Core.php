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
            $parametros['erro'] = "Essa página não existe.";
        }
        
        if ($metodo === 'buscarNomeAluno') {
            $controller = 'PadrinhoController';
        }

        $id = isset($urlGet['id']) ? $urlGet['id'] : null;
        $nome = isset($urlGet['nome']) ? $urlGet['nome'] : null;

        try {
            ob_start();
            call_user_func_array([new $controller, $metodo], $parametros = [$id, $nome]);
            $saida = ob_get_clean();

            return $saida;
        } catch (Exception $e) {
            $controller = 'ErroController';
            $metodo = 'index';
            $parametros['erro'] = $e->getMessage();
            ob_start();
            call_user_func_array([new $controller, $metodo], [$parametros]);
            return ob_get_clean();
        }
    }
}
