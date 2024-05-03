<?php

class Usuario
{
    public static function selecionaTodos()
    {
        $con = Connection::getConn();

        $sql = "SELECT * FROM usuario";
        $sql = $con->prepare($sql);
        $sql->execute();
        
        $resultado = array();

        while($row = $sql->fetchObject('Usuario')){
            $resultado[] = $row;
        }

        if(!$resultado){
            throw new Exception("Não foi encontrado nenhum registro no banco de dados.");
        }

        return $resultado;
    }
}
