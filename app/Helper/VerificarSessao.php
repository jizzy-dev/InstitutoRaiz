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

    public static function verificarPerfil(String $perfilNecessario)
    {
        if ($_SESSION['user']->perfil_acesso !== $perfilNecessario) {
            header("Location: ?pag=erro&metodo=acesso&allowed=false");
            exit();
        }
    }
}
