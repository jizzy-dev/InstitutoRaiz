<?php
class Frequencia
{
    public static function marcarFrequencia($idAluno, $idTurma, $data_aula, $presenca)
    {
        $con = Connection::getConn();

        $sql = "INSERT INTO frequencia (data_aula, presenca, ID_ALUNO, ID_TURMA) 
                VALUES(:data_aula, :presenca, :id_aluno, :id_turma)";
        $sql = $con->prepare($sql);

        // Certifique-se de que data_aula é uma data válida
        if (!self::isValidDate($data_aula)) {
            throw new Exception("Data inválida: $data_aula");
        }

        $sql->bindValue(':data_aula', $data_aula);
        $sql->bindValue(':presenca', $presenca);
        $sql->bindValue(':id_aluno', $idAluno, PDO::PARAM_INT);
        $sql->bindValue(':id_turma', $idTurma, PDO::PARAM_INT);

        if ($sql->execute()) {
            return true;
        } else {
            throw new Exception("Erro ao marcar frequência.");
        }
    }

    private static function isValidDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    public static function consultarFrequencia($idTurma)
    {
        $con = Connection::getConn();

        $sql = "SELECT * FROM frequencia WHERE ID_TURMA = :idTurma";
        $sql = $con->prepare($sql);
        $sql->bindValue(':idTurma', $idTurma, PDO::PARAM_INT);
        $sql->execute();

        $frequencias = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $frequencias;
    }
}

