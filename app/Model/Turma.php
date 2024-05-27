<?php
class Turma {
    public static function selecionarTodas() {
        $con = Connection::getConn();

        $sql = "SELECT * FROM turma";
        $sql = $con->prepare($sql);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_OBJ);
    }
}
