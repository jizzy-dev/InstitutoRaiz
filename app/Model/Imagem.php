<?php
class Imagem
{
    public static function Create($dados)
    {
        $con = Connection::getConn();

        $sql = "INSERT INTO imagem (imgCaminho) VALUES (:imgCaminho)";
        $sql = $con->prepare($sql);
        $sql->bindValue(':imgCaminho', $dados['imgCaminho']);
        $sql->execute();

        $resultado = $con->lastInsertId();

        return $resultado;
    }

    public static function selecionarPorId($idImagem)
    {
        $con = Connection::getConn();

        $sql = "SELECT * FROM imagem WHERE ID_IMAGEM = :id";
        $sql = $con->prepare($sql);
        $sql->bindValue(':id', $idImagem, PDO::PARAM_INT);
        $sql->execute();

        return $sql->fetchObject('Imagem');
    }

    public static function atualizarImagem($dados)
    {
        $con = Connection::getConn();

        $sql = "UPDATE imagem SET imgCaminho = :imgCaminho WHERE ID_IMAGEM = :id_imagem";

        $sql = $con->prepare($sql);

        $sql->bindValue(':imgCaminho', $dados['imgCaminho']);
        $sql->bindValue(':id_imagem', $dados['ID_IMAGEM']);

        if (!$sql->execute()) {
            throw new Exception("Erro ao atualizar imagem.");
        }
    }

    public static function upload($imagem)
    {
        if (!isset($imagem['tmp_name']) || empty($imagem['tmp_name'])) {
            throw new Exception("Nenhuma imagem foi enviada.");
        }

        $tamanhoMaximo = 5 * 1024 * 1024;
        if ($imagem['size'] > $tamanhoMaximo) {
            throw new Exception("O arquivo enviado é muito grande. O limite é de 5MB.");
        }

        $check = getimagesize($imagem['tmp_name']);
        if ($check === false) {
            throw new Exception("O arquivo enviado não é uma imagem válida.");
        }

        $diretorio = $_SERVER['DOCUMENT_ROOT'] . "/InstitutoRaiz/public/assets/images/uploaded/";

        $nome_arquivo = uniqid() . '_' . basename($imagem['name']);
        $caminho_completo = $diretorio . $nome_arquivo;

        if (!move_uploaded_file($imagem['tmp_name'], $caminho_completo)) {
            throw new Exception("Erro ao fazer o upload da imagem.");
        }

        $dadosImagem = [
            'imgCaminho' => "https://localhost/InstitutoRaiz/public/assets/images/uploaded/" . $nome_arquivo
        ];
        $id_imagem = Imagem::Create($dadosImagem);

        return $id_imagem;
    }

    public static function uploadUpdate($imagem, $id_imagem)
    {
        if (!isset($imagem['tmp_name']) || empty($imagem['tmp_name'])) {
            throw new Exception("Nenhuma imagem foi enviada.");
        }

        $tamanhoMaximo = 5 * 1024 * 1024;
        if ($imagem['size'] > $tamanhoMaximo) {
            throw new Exception("O arquivo enviado é muito grande. O limite é de 5MB.");
        }

        $check = getimagesize($imagem['tmp_name']);
        if ($check === false) {
            throw new Exception("O arquivo enviado não é uma imagem válida.");
        }

        $diretorio = $_SERVER['DOCUMENT_ROOT'] . "/InstitutoRaiz/public/assets/images/uploaded/";
        $nome_arquivo = uniqid() . '_' . basename($imagem['name']);
        $caminho_completo = $diretorio . $nome_arquivo;

        if (!move_uploaded_file($imagem['tmp_name'], $caminho_completo)) {
            throw new Exception("Erro ao fazer o upload da imagem.");
        }

        $dadosImagem = [
            'imgCaminho' => "https://localhost/InstitutoRaiz/public/assets/images/uploaded/" . $nome_arquivo
        ];

        if ($id_imagem == 1) {
            return self::Create($dadosImagem);
        } else {
            $dadosImagem['ID_IMAGEM'] = $id_imagem;
            self::atualizarImagem($dadosImagem);
            return $id_imagem;
        }
    }
}
