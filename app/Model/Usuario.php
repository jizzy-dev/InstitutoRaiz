<?php

class Usuario
{
    public static function Create($dados)
    {
        $con = Connection::getConn();

        $sql = "INSERT INTO usuario 
        (nome, cpf, rg, contato, email, senha, data_nasc, cep, logradouro, 
        bairro, numero_endereco, complemento, cidade, estado, isResponsavel, 
        isPadrinho, perfil_acesso, ID_IMAGEM) 
        VALUES (:nome, :cpf, :rg, :contato, :email, :senha, :data_nasc, :cep, 
        :logradouro, :bairro, :numero_endereco, :complemento, :cidade, :estado, 
        :isResponsavel, :isPadrinho, :perfil_acesso, :ID_IMAGEM)";

        $sql = $con->prepare($sql);

        $sql->bindValue(':nome', htmlspecialchars($dados['nome']));
        $sql->bindValue(':cpf', htmlspecialchars($dados['cpf']));
        $sql->bindValue(':rg', htmlspecialchars($dados['rg']));
        $sql->bindValue(':contato', htmlspecialchars($dados['contato']));
        $sql->bindValue(':email', htmlspecialchars($dados['email']));
        $sql->bindValue(':senha', password_hash($dados['senha'], PASSWORD_DEFAULT));
        $sql->bindValue(':data_nasc', htmlspecialchars($dados['data_nasc']));
        $sql->bindValue(':cep', htmlspecialchars($dados['cep']));
        $sql->bindValue(':logradouro', htmlspecialchars($dados['logradouro']));
        $sql->bindValue(':bairro', htmlspecialchars($dados['bairro']));
        $sql->bindValue(':numero_endereco', htmlspecialchars($dados['numero_endereco']));
        $sql->bindValue(':complemento', htmlspecialchars($dados['complemento']));
        $sql->bindValue(':cidade', htmlspecialchars($dados['cidade']));
        $sql->bindValue(':estado', htmlspecialchars($dados['estado']));
        $sql->bindValue(':isResponsavel', isset($dados['isResponsavel']) ? htmlspecialchars($dados['isResponsavel']) : 0);
        $sql->bindValue(':isPadrinho', isset($dados['isPadrinho']) ? htmlspecialchars($dados['isPadrinho']) : 0);
        $sql->bindValue(':perfil_acesso', isset($dados['perfil_acesso']) ? htmlspecialchars($dados['perfil_acesso']) : 'U');
        $sql->bindValue(':ID_IMAGEM', isset($dados['ID_IMAGEM']) ? $dados['ID_IMAGEM'] : 1);

        if ($sql->execute()) {
            return $con->lastInsertId();
        } else {
            throw new Exception("Erro ao cadastrar um usuário.");
        }
    }
    public static function selecionaTodos()
    {
        $con = Connection::getConn();

        $sql = "SELECT * FROM usuario LIMIT 25";
        $sql = $con->prepare($sql);
        $sql->execute();

        $resultado = array();

        while ($row = $sql->fetchObject('Usuario')) {
            $resultado[] = $row;
        }

        if (!$resultado) {
            throw new Exception("Nenhum Registro Encontrado.");
        }

        return $resultado;
    }
    public static function selecionarPorId($idUser)
    {
        $con = Connection::getConn();

        $sql = "SELECT * FROM usuario WHERE ID_USER = :id";
        $sql = $con->prepare($sql);
        $sql->bindValue(':id', $idUser, PDO::PARAM_INT);
        $sql->execute();

        $resultado = $sql->fetchObject('Usuario');

        if (!$resultado) {
            throw new Exception("Nenhum Registro Encontrado.");
        }

        return $resultado;
    }
    public static function selecionarPadrinhos()
    {
        $con = Connection::getConn();

        $sql = "SELECT * FROM vw_padrinho LIMIT 25";
        $sql = $con->prepare($sql);
        $sql->execute();

        $resultado = array();

        while ($row = $sql->fetchObject('Usuario')) {
            $resultado[] = $row;
        }

        if (!$resultado) {
            throw new Exception("Nenhum Registro Encontrado.");
        }

        return $resultado;
    }
    public static function selecionarPadrinhoPorId($id)
    {
        $con = Connection::getConn();

        $sql = "SELECT * FROM vw_padrinho WHERE ID_USER = :id";
        $sql = $con->prepare($sql);
        $sql->bindValue(':id', $id, PDO::PARAM_INT);
        $sql->execute();

        $resultado = $sql->fetchObject('Usuario');

        if (!$resultado) {
            throw new Exception("Nenhum Registro Encontrado.");
        }

        return $resultado;
    }
    public static function atualizarPorId($dados)
    {
        $con = Connection::getConn();
        $sql = "UPDATE usuario 
                SET nome = :nome, cpf = :cpf, rg = :rg, contato = :contato, 
                    email = :email, senha = :senha, data_nasc = :data_nasc, cep = :cep, 
                    logradouro = :logradouro, bairro = :bairro, 
                    numero_endereco = :numero_endereco, complemento = :complemento, 
                    cidade = :cidade, estado = :estado, ID_IMAGEM = :ID_IMAGEM 
                WHERE ID_USER = :id";
        $sql = $con->prepare($sql);
        $sql->bindValue(':id', $dados['id'], PDO::PARAM_INT);
        $sql->bindValue(':nome', htmlspecialchars($dados['nome']));
        $sql->bindValue(':cpf', htmlspecialchars($dados['cpf']));
        $sql->bindValue(':rg', htmlspecialchars($dados['rg']));
        $sql->bindValue(':contato', htmlspecialchars($dados['contato']));
        $sql->bindValue(':email', htmlspecialchars($dados['email']));
        $sql->bindValue(':senha', password_hash($dados['senha'], PASSWORD_DEFAULT));
        $sql->bindValue(':data_nasc', htmlspecialchars($dados['data_nasc']));
        $sql->bindValue(':cep', htmlspecialchars($dados['cep']));
        $sql->bindValue(':logradouro', htmlspecialchars($dados['logradouro']));
        $sql->bindValue(':bairro', htmlspecialchars($dados['bairro']));
        $sql->bindValue(':numero_endereco', htmlspecialchars($dados['numero_endereco']));
        $sql->bindValue(':complemento', htmlspecialchars($dados['complemento']));
        $sql->bindValue(':cidade', htmlspecialchars($dados['cidade']));
        $sql->bindValue(':estado', htmlspecialchars($dados['estado']));
        $sql->bindValue(':ID_IMAGEM', $dados['ID_IMAGEM']);

        if (!$sql->execute()) {
            throw new Exception("Erro ao atualizar usuário.");
        }
    }
    public static function deletarPorId($idUser)
    {
        $con = Connection::getConn();

        $sql = "DELETE FROM usuario WHERE ID_USER = :id";
        $sql = $con->prepare($sql);
        $sql->bindValue(':id', $idUser, PDO::PARAM_INT);
        $sql->execute();
    }
    public static function filtrar($nomeUser)
    {
        $con = Connection::getConn();

        $sql = "SELECT * FROM usuario WHERE nome LIKE :nome LIMIT 25";
        $sql = $con->prepare($sql);

        $nomeFiltrado = '%' . $nomeUser . '%';

        $sql->bindValue(':nome', $nomeFiltrado, PDO::PARAM_STR);
        $sql->execute();

        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

        if (!$resultado) {
            throw new Exception("Nenhum Registro Encontrado..");
        }

        return $resultado;
    }
    public static function bindPadrinho($dados)
    {
        $con = Connection::getConn();

        $sql = "UPDATE usuario 
        SET  isPadrinho = :isPadrinho
        WHERE ID_USER = :id";

        $sql = $con->prepare($sql);

        $sql->bindValue(':id', $dados['id_padrinho'], PDO::PARAM_INT);
        $sql->bindValue(':isPadrinho', $dados['isPadrinho']);


        if ($sql->execute()) {
            return true;
        } else {
            throw new Exception("Erro ao atribuir Padrinho.");
        }
    }
    public static function atualizarPerfilAcesso($dados)
    {
        $con = Connection::getConn();
        $sql = "UPDATE usuario 
                SET perfil_acesso = :perfil_acesso 
                WHERE ID_USER = :id";
        $sql = $con->prepare($sql);
        $sql->bindValue(':id', $dados['id'], PDO::PARAM_INT);
        $sql->bindValue(':perfil_acesso', $dados['perfil_acesso'], PDO::PARAM_STR);


        if (!$sql->execute()) {
            throw new Exception("Erro ao alterar perfil do usuário.");
        }
    }
}
