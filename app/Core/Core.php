<?php

class Core
{
    public function run($urlGet)
    {
        $metodo = 'index';
        if (isset($_GET['pag'])) {
            $controller = ucfirst($urlGet['pag'] . 'Controller');
        } else {
            $controller = 'HomeController';
        }

        if (!class_exists($controller)) {
            $controller = 'ErroController';
        }

        call_user_func_array(array(new $controller, $metodo),array());
    }
}
