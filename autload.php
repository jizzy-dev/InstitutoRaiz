<?php
spl_autoload_register(function($file_name){
    if(file_exists('controllers/'.$file_name.'.php')){
        require 'controllers/'.$file_name.'.php';
    }elseif(file_exists('models/'.$file_name.'.php')){
        require 'models/'.$file_name.'.php';
    }
    elseif(file_exists('core/'.$file_name.'.php')){
        require 'core/'.$file_name.'.php';
    }
});
?>