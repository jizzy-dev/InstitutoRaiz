<?php
class Autenticar{
    public static function login($dados){
        $con = Connection::getConn();

        $sql = "SELECT * FROM usuario WHERE email = :email LIMIT 1";
        $sql = $con->prepare($sql);
        $sql->bindValue(':email', $dados['email'], PDO::PARAM_STR);
        $sql->execute();

        $user = $sql->fetchObject('Usuario');

        if ($user && password_verify($dados['senha'], $user->senha)) {
            return $user;
        } else {
            throw new Exception("E-mail ou senha incorretos.");
        }
    }
    
}