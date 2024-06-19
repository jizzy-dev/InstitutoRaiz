<?php
class VerificarSessao
{
    public static function verificarLogin()
    {
        if (!isset($_SESSION['user'])) {
            session_destroy();
            header("Location: ?pag=autenticar");
            exit();
        }
    }

    public static function verificarPerfil(array $perfisNecessarios)
    {
        if (Autorizar::verificarAutorizacao($perfisNecessarios)) {
            header("Location: ?pag=erro&metodo=acesso&allowed=false");
            exit();
        }
    }
    public static function verificarAcesso(array $perfisNecessarios){
        VerificarSessao::verificarLogin();
        VerificarSessao::verificarPerfil($perfisNecessarios);
    }
}
