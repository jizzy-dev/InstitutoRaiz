<?php
class ValidarDuplos
{
    public static function verificarEmailDuplo($email)
    {
        $con = Connection::getConn();

        $sql = "SELECT email FROM usuario WHERE email = :email";
        $sql = $con->prepare($sql);
        $sql->bindValue(':email', htmlspecialchars($email));
        $sql->execute();

        $resultado = $sql->fetch(PDO::FETCH_ASSOC);

        return $resultado !== false;
    }
    public static function verificarCPFDuplo($cpf)
    {
        $con = Connection::getConn();

        $sql = "SELECT cpf FROM usuario WHERE cpf = :cpf";
        $sql = $con->prepare($sql);
        $sql->bindValue(':cpf', htmlspecialchars($cpf));
        $sql->execute();

        $resultado = $sql->fetch(PDO::FETCH_ASSOC);

        return $resultado !== false;
    }
}
