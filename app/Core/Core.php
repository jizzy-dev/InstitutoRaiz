<?php

class Core
{
    public function run($urlGet)
    {

        $metodo = 'index';
        if (isset($_GET['pag'])) {
            $controller = ucfirst($urlGet['pag'] . 'Controller'); //
            if (isset($urlGet['metodo'])) {
                $metodo = $urlGet['metodo'];
            }
        } else {
            $controller = 'HomeController';
        }

        if (!class_exists($controller)) {
            $controller = 'ErroController';
        }

        (isset($urlGet['id']) && $urlGet['id'] != null) ? 
        $id = $urlGet['id'] :
        $id = null;

        
        
        call_user_func_array(array(new $controller, $metodo), array($id));
    }
}
