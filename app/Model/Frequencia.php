<?php
class Frequencia{
    public static function marcarFrequencia($idAluno, $data_aula, $falta){
        $con = Connection::getConn();

        $sql = "INSERT INTO frequencia (data_aula, falta, ID_ALUNO) 
                VALUES(:data_aula, :falta, :id_aluno)";
        $sql = $con->prepare($sql);

        $sql->bindValue(':data_aula', $data_aula);
        $sql->bindValue(':falta', $falta);
        $sql->bindValue(':id_aluno', $idAluno);

        if ($sql->execute()) {
            return true;
        } else {
            throw new Exception("Erro ao marcar frequência.");
        }
    }

    public static function consultarFrequencia($idAluno){
        $con = Connection::getConn();

        $sql = "SELECT * FROM frequencia WHERE ID_ALUNO = :idAluno";
        $sql = $con->prepare($sql);
        $sql->bindValue(':idAluno', $idAluno, PDO::PARAM_INT);
        $sql->execute();

        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $resultado;
    }
}
