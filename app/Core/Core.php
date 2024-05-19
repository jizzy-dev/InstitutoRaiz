<?php

class Core
{
    public function run($urlGet)
    {
        
        $metodo = 'index';
        if (isset($_GET['pag'])) {
            $controller = ucfirst($urlGet['pag'] . 'Controller'); //
           try {
             if (isset($urlGet['metodo']) && $urlGet['metodo']) {
                 $metodo = $urlGet['metodo'];
             }
           } catch (Exception $e) {
                $metodo = 'index';
           }
        } else {
            $controller = 'HomeController';
        }

        if (!class_exists($controller)) {
            $controller = 'ErroController';
        }
        

        $id = isset($urlGet['id']) && $urlGet['id'] !== null ? $urlGet['id'] : null;
        $nome = isset($urlGet['nome']) && $urlGet['nome'] !== null ? $urlGet['nome'] : null;
        

<<<<<<< Updated upstream
        call_user_func_array(array(new $controller, $metodo), array($id,$nome));
=======
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
>>>>>>> Stashed changes
    }
}
