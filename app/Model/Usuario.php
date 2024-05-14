<?php

class Usuario
{
    public static function selecionaTodos()
    {
        $con = Connection::getConn();

        $sql = "SELECT * FROM usuario LIMIT 5";
        $sql = $con->prepare($sql);
        $sql->execute();

        $resultado = array();

        while ($row = $sql->fetchObject('Usuario')) {
            $resultado[] = $row;
        }

        if (!$resultado) {
            throw new Exception("Não foi encontrado nenhum registro no banco de dados.");
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
            throw new Exception("Não foi encontrado nenhum registro no banco de dados.");
        }

        return $resultado;
    }
    public static function cadastrar($dados)
    {
        $con = Connection::getConn();

        $sql = "INSERT INTO usuario 
        (nome, cpf, rg, contato, email, senha, data_nasc, cep, logradouro, 
        bairro, numero_endereco, complemento, cidade, estado, isResponsavel, 
        isPadrinho, isAdm, isMod, ID_IMAGEM) 
        VALUES (:nome, :cpf, :rg, :contato, :email, :senha, :data_nasc, :cep, 
        :logradouro, :bairro, :numero_endereco, :complemento, :cidade, :estado, 
        :isResponsavel, :isPadrinho, :isAdm, :isMod, :ID_IMAGEM)";

        $sql = $con->prepare($sql);

        $sql->bindValue(':nome', $dados['nome']);
        $sql->bindValue(':cpf', $dados['cpf']);
        $sql->bindValue(':rg', $dados['rg']);
        $sql->bindValue(':contato', $dados['contato']);
        $sql->bindValue(':email', $dados['email']);
        $sql->bindValue(':senha', $dados['senha']);
        $sql->bindValue(':data_nasc', $dados['data_nasc']);
        $sql->bindValue(':cep', $dados['cep']);
        $sql->bindValue(':logradouro', $dados['logradouro']);
        $sql->bindValue(':bairro', $dados['bairro']);
        $sql->bindValue(':numero_endereco', $dados['numero_endereco']);
        $sql->bindValue(':complemento', $dados['complemento']);
        $sql->bindValue(':cidade', $dados['cidade']);
        $sql->bindValue(':estado', $dados['estado']);
        $sql->bindValue(':isResponsavel', isset($dados['isResponsavel']) ? $dados['isResponsavel'] : null);
        $sql->bindValue(':isPadrinho', isset($dados['isPadrinho']) ? $dados['isPadrinho'] : null);
        $sql->bindValue(':isAdm', isset($dados['isAdm']) ? $dados['isAdm'] : null);
        $sql->bindValue(':isMod', isset($dados['isMod']) ? $dados['isMod'] : null);
        $sql->bindValue(':ID_IMAGEM', $dados['ID_IMAGEM']);

        if ($sql->execute()) {
            return true;
        } else {
            throw new Exception("Erro ao cadastrar usuário.");
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
    public static function atualizarPorId($dados)
    {
        $con = Connection::getConn();

        $sql = "UPDATE usuario 
        SET nome = :nome, cpf = :cpf, rg = :rg, contato = :contato, 
        email = :email, senha = :senha, data_nasc = :data_nasc, cep = :cep, 
        logradouro = :logradouro, bairro = :bairro, 
        numero_endereco = :numero_endereco, complemento = :complemento, 
        cidade = :cidade, 
        estado = :estado, isResponsavel = :isResponsavel, isPadrinho = :isPadrinho, 
        isAdm = :isAdm, isMod = :isMod, ID_IMAGEM = :id_imagem 
        WHERE ID_USER = :id";

        $sql = $con->prepare($sql);

        $sql->bindValue(':id', $dados['id'], PDO::PARAM_INT);
        $sql->bindValue(':nome', $dados['nome']);
        $sql->bindValue(':cpf', $dados['cpf']);
        $sql->bindValue(':rg', $dados['rg']);
        $sql->bindValue(':contato', $dados['contato']);
        $sql->bindValue(':email', $dados['email']);
        $sql->bindValue(':senha', $dados['senha']);
        $sql->bindValue(':data_nasc', $dados['data_nasc']);
        $sql->bindValue(':cep', $dados['cep']);
        $sql->bindValue(':logradouro', $dados['logradouro']);
        $sql->bindValue(':bairro', $dados['bairro']);
        $sql->bindValue(':numero_endereco', $dados['numero_endereco']);
        $sql->bindValue(':complemento', $dados['complemento']);
        $sql->bindValue(':cidade', $dados['cidade']);
        $sql->bindValue(':estado', $dados['estado']);
        $sql->bindValue(':isResponsavel', isset($dados['isResponsavel']) ? $dados['isResponsavel'] : 0);
        $sql->bindValue(':isPadrinho', isset($dados['isPadrinho']) ? $dados['isPadrinho'] : 0);
        $sql->bindValue(':isAdm', isset($dados['isAdm']) ? $dados['isAdm'] : 0);
        $sql->bindValue(':isMod', isset($dados['isMod']) ? $dados['isMod'] : 0);
        $sql->bindValue(':id_imagem', $dados['ID_IMAGEM']);

        if ($sql->execute()) {
            return true;
        } else {
            throw new Exception("Erro ao atualizar usuário.");
        }
    }

    public static function filtrar($nomeUser)
    {
        $con = Connection::getConn();

        $sql = "SELECT * FROM usuario WHERE nome LIKE :nome LIMIT 5";
        $sql = $con->prepare($sql);

        $nomeFiltrado = '%' . $nomeUser . '%';

        $sql->bindValue(':nome', $nomeFiltrado, PDO::PARAM_STR);
        $sql->execute();

        $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

        if (!$resultado) {
            throw new Exception("Não foi encontrado nenhum registro no banco de dados.");
        }

        return $resultado;
    }
}
