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
        
        $resultado = $sql->fetchObject('Usuario');

        if (!$resultado) {
            throw new Exception("Nenhum Registro Encontrado.");
        }

        return $resultado;
    }
    public static function selecionarPorId($idImagem)
    {
        $con = Connection::getConn();

        $sql = "SELECT * FROM imagem WHERE ID_IMAGEM = :id";
        $sql = $con->prepare($sql);
        $sql->bindValue(':id', $idImagem, PDO::PARAM_INT);
        $sql->execute();

        $resultado = $sql->fetchObject('Imagem');

        if (!$resultado) {
            throw new Exception("Nenhum registro encontrado.");
        }

        return $resultado;
    }
    public static function upload($imagem)
    {
        // Verifica se foi enviado um arquivo
        if (!isset($imagem['tmp_name']) || empty($imagem['tmp_name'])) {
            throw new Exception("Nenhuma imagem foi enviada.");
        }

        // Verifica o tamanho do arquivo (limite de 5MB, por exemplo)
        $tamanhoMaximo = 5 * 1024 * 1024; // 5MB em bytes
        if ($imagem['size'] > $tamanhoMaximo) {
            throw new Exception("O arquivo enviado é muito grande. O limite é de 5MB.");
        }

        // Verifica se o arquivo é uma imagem
        $check = getimagesize($imagem['tmp_name']);
        if ($check === false) {
            throw new Exception("O arquivo enviado não é uma imagem válida.");
        }

        // Diretório onde as imagens serão armazenadas
        $diretorio = $_SERVER['DOCUMENT_ROOT'] . "/InstitutoRaiz/public/assets/images/uploaded/";

        // Gera um nome único para a imagem
        $nome_arquivo = uniqid() . '_' . basename($imagem['name']);

        // Caminho completo onde a imagem será armazenada
        $caminho_completo = $diretorio . $nome_arquivo;

        // Move o arquivo enviado para o diretório de destino
        if (!move_uploaded_file($imagem['tmp_name'], $caminho_completo)) {
            throw new Exception("Erro ao fazer o upload da imagem.");
        }

        // Agora, salve o caminho da imagem no banco de dados e obtenha o ID da imagem inserida
        $dadosImagem = [
            'imgCaminho' => "https://localhost/InstitutoRaiz/public/assets/images/uploaded/" . $nome_arquivo
        ];
        $id_imagem = Imagem::Create($dadosImagem);

        // Retorna o ID da imagem inserida no banco de dados
        return $id_imagem;
    }
}
