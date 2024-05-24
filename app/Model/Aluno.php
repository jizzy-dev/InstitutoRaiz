<?php

class Aluno
{
    public static function Create($dados)
    {
        $con = Connection::getConn();

        $sql = "INSERT INTO aluno 
        (nome, cpf, rg, data_nasc, certidao, carteira_vacina, situacao_matricula, data_matricula, 
        data_inicio, ID_TURMA, ID_USER_RESPONSAVEL, ID_USER_PADRINHO) 
        VALUES (:nome, :cpf, :rg, :data_nasc, :certidao, :carteira_vacina, :situacao_matricula, 
        :data_matricula, :data_inicio, :ID_TURMA, :ID_USER_RESPONSAVEL, :ID_USER_PADRINHO)";

        $sql = $con->prepare($sql);

        $sql->bindValue(':nome', $dados['nome']);
        $sql->bindValue(':cpf', $dados['cpf']);
        $sql->bindValue(':rg', $dados['rg']);
        $sql->bindValue(':data_nasc', $dados['data_nasc']);
        $sql->bindValue(':certidao', $dados['certidao']);
        $sql->bindValue(':carteira_vacina', $dados['carteira_vacina']);
        $sql->bindValue(':situacao_matricula', isset($dados['situacao_matricula']) ? $dados['situacao_matricula'] : 'pendente');
        $sql->bindValue(':data_matricula', $dados['data_matricula']);
        $sql->bindValue(':data_inicio', $dados['data_inicio']);
        $sql->bindValue(':ID_TURMA', $dados['ID_TURMA']);
        $sql->bindValue(':ID_USER_RESPONSAVEL', $dados['ID_USER_RESPONSAVEL']);
        $sql->bindValue(':ID_USER_PADRINHO', $dados['ID_USER_PADRINHO']);

        if ($sql->execute()) {
            return true;
        } else {
            throw new Exception("Erro ao cadastrar aluno.");
        }
    }

    public static function selecionarPorId($idAluno)
    {
        $con = Connection::getConn();

        $sql = "SELECT * FROM aluno WHERE ID_ALUNO = :id";
        $sql = $con->prepare($sql);
        $sql->bindValue(':id', $idAluno, PDO::PARAM_INT);
        $sql->execute();

        $resultado = $sql->fetchObject('Aluno');

        if (!$resultado) {
            throw new Exception("Nenhum registro encontrado.");
        }

        return $resultado;
    }

    public static function selecionarPorTurma($idTurma) {
        $con = Connection::getConn();

        $sql = "SELECT * FROM aluno WHERE ID_TURMA = :idTurma";
        $sql = $con->prepare($sql);
        $sql->bindValue(':idTurma', $idTurma, PDO::PARAM_INT);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_OBJ);
    }
    public static function atualizarPorId($dados)
    {
        $con = Connection::getConn();

        $sql = "UPDATE aluno 
        SET nome = :nome, cpf = :cpf, rg = :rg, data_nasc = :data_nasc, certidao = :certidao, 
        carteira_vacina = :carteira_vacina, situacao_matricula = :situacao_matricula, 
        data_matricula = :data_matricula, data_inicio = :data_inicio, ID_TURMA = :ID_TURMA, 
        ID_USER_RESPONSAVEL = :ID_USER_RESPONSAVEL, ID_USER_PADRINHO = :ID_USER_PADRINHO 
        WHERE ID_ALUNO = :id";

        $sql = $con->prepare($sql);

        $sql->bindValue(':id', $dados['id'], PDO::PARAM_INT);
        $sql->bindValue(':nome', $dados['nome']);
        $sql->bindValue(':cpf', $dados['cpf']);
        $sql->bindValue(':rg', $dados['rg']);
        $sql->bindValue(':data_nasc', $dados['data_nasc']);
        $sql->bindValue(':certidao', $dados['certidao']);
        $sql->bindValue(':carteira_vacina', $dados['carteira_vacina']);
        $sql->bindValue(':situacao_matricula', $dados['situacao_matricula']);
        $sql->bindValue(':data_matricula', $dados['data_matricula']);
        $sql->bindValue(':data_inicio', $dados['data_inicio']);
        $sql->bindValue(':ID_TURMA', $dados['ID_TURMA']);
        $sql->bindValue(':ID_USER_RESPONSAVEL', $dados['ID_USER_RESPONSAVEL']);
        $sql->bindValue(':ID_USER_PADRINHO', $dados['ID_USER_PADRINHO']);

        if ($sql->execute()) {
            return true;
        } else {
            throw new Exception("Erro ao atualizar aluno.");
        }
    }

    public static function deletarPorId($idAluno)
    {
        $con = Connection::getConn();

        $sql = "DELETE FROM aluno WHERE ID_ALUNO = :id";
        $sql = $con->prepare($sql);
        $sql->bindValue(':id', $idAluno, PDO::PARAM_INT);
        $sql->execute();
    }

    public static function selecionarTodos()
    {
        $con = Connection::getConn();

        $sql = "SELECT * FROM aluno LIMIT 5";
        $sql = $con->prepare($sql);
        $sql->execute();

        $resultado = array();

        while ($row = $sql->fetchObject('Aluno')) {
            $resultado[] = $row;
        }

        if (!$resultado) {
            throw new Exception("Nenhum registro encontrado.");
        }

        return $resultado;
    }

    public static function filtrar($nomeAluno)
    {
        $con = Connection::getConn();

        $sql = "SELECT * FROM aluno WHERE nome LIKE :nome LIMIT 25";
        $sql = $con->prepare($sql);

        $nomeFiltrado = '%' . $nomeAluno . '%';

        $sql->bindValue(':nome', $nomeFiltrado, PDO::PARAM_STR);
        $sql->execute();

        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

        if (!$resultado) {
            throw new Exception("Nenhum registro encontrado.");
        }

        return $resultado;
    }
    public static function bindPadrinho($dados)
    {
        $con = Connection::getConn();

        $sql = "UPDATE aluno 
                SET ID_USER_PADRINHO = :ID_USER_PADRINHO 
                WHERE ID_ALUNO = :id";

        $sql = $con->prepare($sql);

        $sql->bindValue(':id', $dados['id'], PDO::PARAM_INT);
        $sql->bindValue(':ID_USER_PADRINHO', $dados['ID_USER_PADRINHO']);

        if ($sql->execute()) {
            return true;
        } else {
            throw new Exception("Erro ao atualizar aluno.");
        }
    }
    public static function selecionarPorSituacao($situacao) {
        $con = Connection::getConn();

        $sql = "SELECT * FROM aluno WHERE situacao_matricula = :situacao";
        $sql = $con->prepare($sql);
        $sql->bindValue(':situacao', $situacao);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public static function atualizarTurma($idAluno, $idTurma) {
        $con = Connection::getConn();

        $sql = "UPDATE aluno SET ID_TURMA = :ID_TURMA WHERE ID_ALUNO = :id";
        $sql = $con->prepare($sql);
        $sql->bindValue(':ID_TURMA', $idTurma);
        $sql->bindValue(':id', $idAluno, PDO::PARAM_INT);

        if ($sql->execute()) {
            return true;
        } else {
            throw new Exception("Erro ao atualizar a turma do aluno.");
        }
    }
}
