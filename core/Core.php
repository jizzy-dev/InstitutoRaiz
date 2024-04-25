<?php

Class Core{

    //metodo construtor da classe
    public function __construct(){
        //assim que instaciar a classe core, ela ja chama a função run
        $this -> run(); // $this referencia ao objeto chamado
    } 
    public function run(){
         //verifica se existe informação no GET
         if(isset($_GET['pag'])){
            //se existe guarde em $url
            $url = $_GET['pag'];
        }
        //verifica se existe informação na $url
        if(!empty($url)){
            //tudo delimitado por '/' é seperado individualmente e vira array
            $array_url = explode('/', $url);
            /*ex: www.exemplo.com/gerenciador/cadastrar/10 
             --> '  gerenciador     0 classe
                    cadastrar       1 metodo/funcao
                    10'             2 parametros
            */
            $controller = $array_url[0].'Controller';
            //funcao que tira a posicao '[0]' da array e usa o proximo como '[0]'
            array_shift($array_url);
            //verifica na posicao '[0]'se existe informação e se não esta vazia
            if(isset($array_url[0]) && !empty($array_url[0])){
                $metodo = $array_url[0];
                array_shift($array_url);
            }else //enviou somente classe
            {
                $metodo = 'index';
            }
            //se sobrou algo no $array_url --> guardar
            if(count($array_url)> 0){
                $parametro = $array_url; 
            }
        }else{
            $controller = 'homeController';
            $metodo = 'index';
        }

        $caminho = 'app/controllers/'.$controller.'php';

        //verifica se existe o caminho e se há metodo
        if(!file_exists( $caminho) && !method_exists($controller, $metodo)){
            $controller = 'homeController';
            $metodo = 'index';
        }

        $c = new $controller;
        
        call_user_func_array(array($c, $metodo),$parametro);
    }
}